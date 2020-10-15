<?php //>

use dungeons\db\column\Integer;

return new class() extends dungeons\web\backend\ListController {

    protected function init() {
        $table = table('Menu');
        $table->icon->invisible(true);
        $table->url->invisible(true);
        $table->add('item_count', 'item.count');

        $this->table($table);
    }

    protected function preprocess($form) {
        $form[] = $this->table()->parent_id->isNull();

        return $form;
    }

};
