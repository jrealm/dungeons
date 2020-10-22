<?php //>

use dungeons\db\column\Double;

return new class() extends dungeons\web\backend\InsertController {

    use dungeons\web\backend\SubCreation;

    protected function init() {
        $table = table('WalletLog');
        $table->transaction_id->required(false);
        $table->the_date->required(false);
        $table->debit->required(false);
        $table->credit->required(false);
        $table->balance->required(false);
        $table->remark->required(true);
        $table->add('amount', Double::class)->pseudo(true)->required(true);

        $this->table($table);
    }

    protected function process($form) {
        $wallet = model('Wallet')->get($this->args()[0]);

        if (!$wallet) {
            return ['error' => 'error.DataNotFound'];
        }

        $amount = floatval($form['amount']);

        if ($amount <= 0) {
            return ['error' => 'error.InvalidAmount'];
        }

        $tx = [
            'the_date' => date(cfg('system.date')),
            'wallet_id' => $wallet['id'],
            'amount' => $amount,
            'fee' => 0,
            'creator' => $this->user()['username'],
            'status' => 1, //已入帳
        ];

        if ($form['type'] === '1') {
            $wallet['balance'] -= $amount;
            $tx['type'] = 203; //後台扣除

            $form['credit'] = $amount;
        } else {
            $wallet['balance'] += $amount;
            $tx['type'] = 102; //後台充值

            $form['debit'] = $amount;
        }

        $wallet = model('Wallet')->update($wallet);

        if ($wallet) {
            $tx = model('Transaction')->insert($tx);

            if ($tx) {
                $form['the_date'] = $tx['the_date'];
                $form['transaction_id'] = $tx['id'];
                $form['balance'] = $wallet['balance'];

                return parent::process($form);
            }
        }

        return ['error' => 'error.InsertFailed'];
    }

};
