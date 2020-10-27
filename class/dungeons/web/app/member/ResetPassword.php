<?php //>

namespace dungeons\web\app\member;

use dungeons\web\Controller;
use dungeons\web\Session;

class ResetPassword extends Controller {

    public function available() {
        return ($this->method() === 'POST' && $this->name() === $this->path());
    }

    protected function process($form) {
        $forgot = Session::get('Forgot');

        // 驗證碼

        if (!$forgot || $forgot['code'] !== @$form['code']) {
            return ['error' => 'error.VerificationCodeNotMatched'];
        }

        if (time() - $forgot['time'] > cfg('app.vcode.valid_period')) {
            return ['error' => 'error.VerificationCodeTimeout'];
        }

        // 帳號

        $member = model('Member')->get($forgot['member_id']);

        if (!$member) {
            return ['error' => 'error.MemberNotFound'];
        }

        if ($member['disabled']) {
            return ['error' => 'error.MemberDisabled'];
        }

        $error = $this->verify($member, $form);

        if ($error) {
            return ['error' => $error];
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

        $member['password'] = $password;

        if (!model('Member')->update($member)) {
            return ['error' => 'error.UpdateFailed'];
        }

        Session::remove('Forgot');

        model('MemberLog')->insert([
            'member_id' => $member['id'],
            'type' => 5, //忘記密碼
        ]);

        return ['success' => true, 'message' => i18n('lang.forgot.success')];
    }

    protected function verify($member, $form) {
        return null;
    }

}
