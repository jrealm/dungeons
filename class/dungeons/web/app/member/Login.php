<?php //>

namespace dungeons\web\app\member;

use dungeons\web\Controller;
use dungeons\web\Session;

class Login extends Controller {

    public function available() {
        return ($this->method() === 'POST' && $this->name() === $this->path());
    }

    protected function process($form) {
        $member = $this->query($form);

        if (!$member) {
            return ['error' => 'error.MemberNotFound'];
        }

        if ($member['password'] !== md5($member['id'] . '::' . @$form['password'])) {
            model('MemberLog')->insert([
                'member_id' => $member['id'],
                'type' => 4, //密碼錯誤
            ]);

            return ['success' => true, 'view' => 'error.php', 'error' => 'error.PasswordNotMatched'];
        }

        if ($member['disabled']) {
            return ['error' => 'error.MemberDisabled'];
        }

        Session::set('Member', $member);

        model('MemberLog')->insert([
            'member_id' => $member['id'],
            'type' => 1, //登入
        ]);

        return ['success' => true];
    }

    protected function query($form) {
        return null;
    }

}
