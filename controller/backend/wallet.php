<?php //>

return new class() extends dungeons\web\backend\ListController {

    protected function init() {
        $table = table('Wallet');
        $table->account->invisible(true);
        $table->add('username', 'member.username');
        $table->add('currency', 'currency.title');
        $table->add('log_count', 'log.count');

        $this->table($table);
    }

};
