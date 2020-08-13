<?php //>

use dungeons\web\Session;

return new class() extends dungeons\web\UserController {

    public function __construct() {
        parent::__construct();

        $this->validationView('backend/validation.php');
        $this->view('backend/user/reset-password-success.twig');
    }

    protected function process($form) {
        $user = $this->user();
        $user['password'] = $form['password'];

        $user = model('User')->update($user);

        if ($user === null) {
            return ['error' => 'backend-login.error.UserNotFound'];
        }

        if ($user === false) {
            return ['error' => 'backend-login.error.ResetPasswordFailed'];
        }

        Session::set('User', $user);

        model('UserLog')->insert(['user_id' => $user['id'], 'type' => 3]);

        return ['success' => true];
    }

    protected function validate($form) {
        $errors = [];
        $user = $this->user();

        $current = @$form['current'];

        if ($current === null) {
            $errors[] = ['name' => 'current', 'type' => 'required'];
        } else if ($user['password'] !== md5($user['id'] . '::' . $current)) {
            $errors[] = ['name' => 'current', 'message' => i18n('backend-login.error.PasswordNotMatched')];
        }

        $password = @$form['password'];

        if ($password === null) {
            $errors[] = ['name' => 'password', 'type' => 'required'];
        } else if ($password === $current) {
            $errors[] = ['name' => 'password', 'message' => i18n('backend-login.error.PasswordNotChanged')];
        }

        $confirm = @$form['confirm'];

        if ($confirm === null) {
            $errors[] = ['name' => 'confirm', 'type' => 'required'];
        } else if ($confirm !== $password) {
            $errors[] = ['name' => 'confirm', 'message' => i18n('backend-login.error.PasswordNotConfirmed')];
        }

        return $errors;
    }

};
