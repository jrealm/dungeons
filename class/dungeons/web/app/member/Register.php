<?php //>

namespace dungeons\web\app\member;

use dungeons\web\Controller;
use dungeons\web\Session;

class Register extends Controller {

    public function available() {
        return ($this->method() === 'POST' && $this->name() === $this->path());
    }

    protected function insert($member, $form) {
        return null;
    }

    protected function process($form) {
        $register = Session::get('Register');

        // 驗證碼

        if (!$register || $register['code'] !== @$form['code']) {
            return ['error' => 'error.VerificationCodeNotMatched'];
        }

        if (time() - $register['time'] > cfg('app.vcode.valid_period')) {
            return ['error' => 'error.VerificationCodeTimeout'];
        }

        // 密碼

        $password = @$form['password'];

        if (!preg_match('/^[\w]{6,16}$/', $password)) {
            return ['error' => 'error.InvalidPassword'];
        }

        if ($password !== @$form['confirm']) {
            return ['error' => 'error.PasswordNotConfirmed'];
        }

        //--

        $member = $this->insert($register, $form);

        if (!$member) {
            return ['error' => 'error.InsertFailed'];
        }

        Session::remove('Register');

        return ['success' => true, 'message' => i18n('lang.register.success')];
    }

}
