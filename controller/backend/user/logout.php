<?php //>

use dungeons\web\Session;

return new class() extends dungeons\web\UserController {

    protected function process($form) {
        Session::remove('User');

        return ['success' => true, 'type' => 'reload'];
    }

};
