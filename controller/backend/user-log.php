<?php //>

return new class() extends dungeons\web\backend\ListController {

    protected function init() {
        $table = table('UserLog');
        $table->add('username', 'user.username');

        $this->table($table);
    }

    protected function preprocess($form) {
        if ($this->user()['id'] > 1) {
            $form[] = $this->table()->user_id->greaterThan(1);
        }

        return $form;
    }

};
