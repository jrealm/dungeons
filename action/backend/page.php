<?php //>

return new class() extends dungeons\web\backend\ListAction {

    protected function init() {
        $table = table('Page');
        $table->add('blocks_count', 'blocks.count');

        $names = [
            'path',
            'title',
            'blocks_count',
            'enable_time',
            'disable_time',
        ];

        $this->table($table);
        $this->columns($table->getColumns($names));
    }

};
