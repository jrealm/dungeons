<?php //>

return new class() extends dungeons\web\backend\ListController {

    protected function init() {
        $table = table('Wallet');
        $table->add('username', 'member.username');
        $table->add('currency', 'currency.title');
        $table->add('log_count', 'log.count');

        $names = [
            'username',
            'currency',
            'balance',
            'frozen',
            'log_count',
        ];

        $this->table($table);
        $this->columns($table->getColumns($names));
    }

};
