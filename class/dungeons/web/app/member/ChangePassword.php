<?php //>

namespace dungeons\web\app\member;

use dungeons\web\AppController;
use dungeons\web\Session;

class ChangePassword extends AppController {

    protected function init() {
        $this->validationView('backend/validation.php');
        $this->view('backend/close-modal.twig');
    }

    protected function process($form) {
        $member = $this->member();
        $member['password'] = $form['password'];

        $member = model('Member')->update($member);

        if ($member === null) {
            return ['error' => 'error.MemberNotFound'];
        }

        if ($member === false) {
            return ['error' => 'error.UpdateFailed'];
        }

        Session::set('Member', $member);

        model('MemberLog')->insert([
            'member_id' => $member['id'],
            'type' => 3, //變更密碼
        ]);

        return ['success' => true, 'message' => i18n('app.save.success')];
    }

    protected function validate($form) {
        $errors = [];
        $member = $this->member();

        $current = @$form['current'];

        if ($current === null) {
            $errors[] = ['name' => 'current', 'type' => 'required'];
        } else if ($member['password'] !== md5("{$member['id']}::{$current}")) {
            $errors[] = ['name' => 'current', 'message' => i18n('error.PasswordNotMatched')];
        }

        $password = @$form['password'];

        if ($password === null) {
            $errors[] = ['name' => 'password', 'type' => 'required'];
        } else if ($password === $current) {
            $errors[] = ['name' => 'password', 'message' => i18n('error.PasswordNotChanged')];
        } else if (!preg_match('/^[\w]{6,16}$/', $password)) {
            $errors[] = ['name' => 'password', 'message' => i18n('error.InvalidPassword')];
        }

        $confirm = @$form['confirm'];

        if ($confirm === null) {
            $errors[] = ['name' => 'confirm', 'type' => 'required'];
        } else if ($confirm !== $password) {
            $errors[] = ['name' => 'confirm', 'message' => i18n('error.PasswordNotConfirmed')];
        }

        return $errors;
    }

}
