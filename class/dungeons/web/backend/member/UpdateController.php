<?php //>

namespace dungeons\web\backend\member;

use dungeons\web\backend\UpdateController as Controller;

class UpdateController extends Controller {

    protected function init() {
        $table = table('Member');
        $table->password->required(false);
        $table->password_time->required(false);

        $this->table($table);
    }

    protected function preprocess($form) {
        $table = table('Member');

        if (@$form['password'] === null) {
            $table->password->readonly(true);
            $table->password_time->readonly(true);
        }

        if (@$form['payment_password'] === null) {
            $table->payment_password->readonly(true);
            $table->payment_password_time->readonly(true);
        }

        return $form;
    }

}
