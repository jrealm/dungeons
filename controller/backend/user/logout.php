<?php //>

use dungeons\web\Session;

return new class() extends dungeons\web\UserController {

    protected function process($form) {
        $user = $this->user();

        Session::destroy();

        model('UserLog')->insert(['user_id' => $user['id'], 'type' => 2]);

        return ['success' => true, 'type' => 'reload'];
    }

};
