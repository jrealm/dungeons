<?php //>

return new class() extends dungeons\web\backend\ListController {

    protected function init() {
        $table = table('User');
        $table->add('group_title', 'group.title');

        $names = [
            'username',
            'group_title',
            'begin_date',
            'expire_date',
            'disabled',
        ];

        $this->table($table);
        $this->columns($table->getColumns($names));
    }

    protected function preprocess($form) {
        $form[] = $this->table()->id->greaterThan(1);

        return $form;
    }

};
