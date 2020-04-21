<?php //>

use dungeons\db\column\Integer;

return new class() extends dungeons\web\backend\ListController {

    protected function init() {
        $table = table('Menu');
        $table->add('parent_id', Integer::class)->invisible(true);
        $table->add('item_count', 'item.count');

        $names = [
            'title',
            'item_count',
            'enable_time',
            'disable_time',
            'ranking',
        ];

        $this->table($table);
        $this->columns($table->getColumns($names));
    }

    protected function preprocess($form) {
        $form[] = $this->table()->parent_id->isNull();

        return $form;
    }

};
