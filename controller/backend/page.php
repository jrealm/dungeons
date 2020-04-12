<?php //>

return new class() extends dungeons\web\backend\ListController {

    protected function init() {
        $table = table('Page');
        $table->add('block_count', 'block.count');

        $names = [
            'path',
            'title',
            'block_count',
            'enable_time',
            'disable_time',
        ];

        $this->table($table);
        $this->columns($table->getColumns($names));
    }

};
