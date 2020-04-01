<?php //>

return new class() extends dungeons\web\backend\ListController {

    protected function init() {
        $table = table('Group');

        $names = [
            'title',
        ];

        $this->table($table);
        $this->columns($table->getColumns($names));
    }

};
