<?php //>

return new class() extends dungeons\web\backend\ListController {

    protected function init() {
        $table = table('User');
        $table->password->invisible(true);
        $table->add('group_title', 'group.title');

        $this->table($table);
    }

    protected function preprocess($form) {
        $form[] = $this->table()->id->greaterThan(1);

        return $form;
    }

};
