<?php //>

use dungeons\web\Session;

return new class() extends dungeons\web\Controller {

    public function available() {
        return ($this->method() === 'POST' && $this->name() === $this->path());
    }

    protected function process($form) {
        $user = model('User')->queryByUsername(@$form['username']);

        if (!$user) {
            return ['error' => 'backend-login.error.UserNotFound'];
        }

        if ($user['password'] !== md5($user['id'] . '::' . @$form['password'])) {
            model('UserLog')->insert(['user_id' => $user['id'], 'type' => 4]);

            return ['success' => true, 'view' => 'error.php', 'error' => 'backend-login.error.PasswordNotMatched'];
        }

        Session::set('User', $user);

        model('UserLog')->insert(['user_id' => $user['id'], 'type' => 1]);

        return ['success' => true];
    }

};
