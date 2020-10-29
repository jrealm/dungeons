<?php //>

namespace dungeons\web\app\member;

use dungeons\Config;
use dungeons\Message;
use dungeons\web\AppController;
use dungeons\web\Session;

class VerifyEmail extends AppController {

    protected function init() {
        $this->validationView('backend/validation.php');
    }

    protected function process($form) {
        $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        $mailer = Config::load('gmail');
        $mailer['to'] = $form['mail'];
        $mailer['code'] = $code;

        if (!execute(array_merge($mailer, Message::load('template/verify-mail')))) {
            return ['error' => 'error.EmailFailed'];
        }

        Session::set('Email', ['mail' => $form['mail'], 'code' => $code, 'time' => time()]);

        return ['success' => true, 'message' => i18n('app.mail.success')];
    }

    protected function validate($form) {
        $errors = [];

        $mail = @$form['mail'];

        if ($mail === null) {
            $errors[] = ['name' => 'mail', 'type' => 'required'];
        } else {
            $type = validate($mail, 'email');

            if ($type) {
                $errors[] = ['name' => 'mail', 'type' => $type];
            }
        }

        return $errors;
    }

}
