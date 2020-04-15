<?php //>

return new class() extends dungeons\web\backend\GetController {

    protected function init() {
        $table = table('User');
        $table->password->required(false);

        $this->table($table);
    }

    protected function postprocess($form, $result) {
        if ($result['data']['id'] === 1) {
            return ['error' => 'error.DataNotFound'];
        }

        unset($result['data']['password']);

        return $result;
    }

};
