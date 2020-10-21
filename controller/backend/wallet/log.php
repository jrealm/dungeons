<?php //>

return new class() extends dungeons\web\backend\ListController {

    use dungeons\web\backend\SubList;

    protected function init() {
        $table = table('WalletLog');
        $table->type->invisible(true);
        $table->create_time->invisible(true);
        $table->add('tx_type', 'transaction.type');

        $this->defaultPage(PHP_INT_MAX);
        $this->table($table);
    }

};
