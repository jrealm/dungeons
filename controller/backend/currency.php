<?php //>

return new class() extends dungeons\web\backend\ListController {

    protected function init() {
        $table = table('Currency');
        $table->icon->invisible(true);
        $table->symbol->invisible(true);
        $table->add('rate_count', 'rate.count');

        $this->table($table);
    }

};
