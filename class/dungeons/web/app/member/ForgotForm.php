<?php //>

namespace dungeons\web\app\member;

use dungeons\web\Controller;
use dungeons\web\Session;

class ForgotForm extends Controller {

    protected function init() {
        $this->view('member/forgot-form.twig');
    }

    protected function process($form) {
        $forgot = Session::get('Forgot');

        // 可重發驗證碼的倒數計時
        if ($forgot) {
            $time = $forgot['time'] + $forgot['frozen'] - time();

            if ($time < 0) {
                $time = 0;
            }
        } else {
            $time = 0;
        }

        $member = $time ? model('Member')->get($forgot['member_id']) : null;

        return [
            'success' => true,
            'member' => $member,
            'time' => $time,
        ];
    }

}
