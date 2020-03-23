<?php //>

return new class() extends dungeons\web\backend\GetAction {

    protected function init() {
        $table = table('User');
        $table->password->required(false);

        $this->table($table);
    }

    protected function postprocess($form, $result) {
        unset($result['data']['password']);

        return $result;
    }

};
