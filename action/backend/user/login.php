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
            return ['error' => 'backend-login.error.PasswordNotMatched'];
        }

        Session::set('User', $user);

        return ['success' => true];
    }

};
