<?php //>

return new class() extends dungeons\web\backend\ListController {

    use dungeons\web\backend\SubList;

    protected function init() {
        $table = table('WalletLog');
        $table->add('tx_type', 'transaction.type');

        $names = [
            'the_date',
            'tx_type',
            'debit',
            'credit',
            'balance',
            'remark',
        ];

        $this->table($table);
        $this->columns($table->getColumns($names));
    }

};
