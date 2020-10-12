<?php //>

return new class() extends dungeons\web\backend\GetController {

    protected function init() {
        $table = table('WalletLog');
        $table->add('tx_type', 'transaction.type')->formStyle('select');

        $this->table($table);
    }

    protected function postprocess($form, $result) {
        $names = [
            'the_date',
            'tx_type',
            'debit',
            'credit',
            'balance',
            'remark',
            'create_time',
        ];

        $this->columns($this->table()->getColumns($names));

        return $result;
    }

};
