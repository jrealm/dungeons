<?php //>

namespace dungeons\web\app\member;

use dungeons\web\Controller;
use dungeons\web\Session;

class RegisterForm extends Controller {

    protected function init() {
        $this->view('member/register-form.twig');
    }

    protected function process($form) {
        $register = Session::get('Register');

        // 可重發驗證碼的倒數計時
        if ($register) {
            $time = $register['time'] + $register['frozen'] - time();

            if ($time < 0) {
                $time = 0;
            }
        } else {
            $time = 0;
        }

        $member = $time ? $register : null;

        return [
            'success' => true,
            'member' => $member,
            'time' => $time,
        ];
    }

}
