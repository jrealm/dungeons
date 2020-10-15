<?php //>

return new class() extends dungeons\web\backend\ListController {

    protected function init() {
        $table = table('Page');
        $table->add('block_count', 'block.count');

        $this->table($table);
    }

};
