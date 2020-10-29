<?php //>

namespace dungeons\web\app\mastercard;

use dungeons\Attachment;
use dungeons\utility\Fn;
use dungeons\web\AppController;
use dungeons\web\Session;

class ApplyPassportAuth extends AppController {

    protected function init() {
        $this->validationView('backend/validation.php');
        $this->view('raw.php');
    }

    protected function process($form) {
        $verify = Session::get('Email');

        // Email

        if (@$verify['mail'] !== $form['mail']) {
            return ['error' => 'error.EmailNotMatched'];
        }

        // 驗證碼

        if ($verify['code'] !== $form['code']) {
            return ['error' => 'error.VerificationCodeNotMatched'];
        }

        if (time() - $verify['time'] > cfg('app.vcode.valid_period')) {
            return ['error' => 'error.VerificationCodeTimeout'];
        }

        // 狀態

        $member = $this->member();
        $model = model('MemberPassportAuth');

        if ($model->count(['member_id' => $member['id'], 'status' => 1])) {
            return ['error' => 'error.PassportAuthApproving'];
        }

        if ($model->count(['member_id' => $member['id'], 'status' => 3])) {
            return ['error' => 'error.PassportAuthApproved'];
        }

        //--

        $data = array_intersect_key($form, array_flip([
            'mail',
            'last_name',
            'first_name',
            'birthday',
            'sex',
            'nationality_id',
            'id_number',
            'photocopy1',
            'photocopy2',
        ]));

        $data['member_id'] = $member['id'];
        $data['language'] = constant('LANGUAGE');

        $data = $model->insert($data);

        if (!$data) {
            return ['error' => 'error.InsertFailed'];
        }

        //--

        if (!$member['mail']) {
            $member['mail'] = $form['mail'];

            if (!model('Member')->update($member)) {
                return ['error' => 'error.InsertFailed'];
            }
        }

        Session::remove('Email');

        return ['success' => true, 'type' => 'refresh', 'message' => i18n('app.passport.success'), 'data' => $data];
    }

    protected function postprocess($form, $result) {
        $member = $this->member();
        $url = Fn::app_url() . 'backend/member-passport-auth/' . $result['data']['id'];

        Fn::telegram("會員 {$member['username']} 提出<a href=\"{$url}\">護照認證</a>");

        unset($result['data']);

        return $result;
    }

    protected function validate($form) {
        $errors = [];

        foreach (['mail', 'code', 'last_name', 'first_name', 'birthday', 'sex', 'nationality_id', 'id_number'] as $name) {
            if (@$form[$name] === null) {
                $errors[] = ['name' => $name, 'type' => 'required'];
            }
        }

        $options = ['mimeType' => 'image\/[\w]+', 'validation' => 'image'];

        foreach (['photocopy1', 'photocopy2'] as $name) {
            $value = @$form[$name];

            if ($value === null) {
                $errors[] = ['name' => $name, 'type' => 'required'];
            } else {
                $type = validate($value, $options);

                if ($type) {
                    $errors[] = ['name' => $name, 'type' => $type];
                }
            }
        }

        return $errors;
    }

    protected function wrap() {
        $form = parent::wrap();

        return Attachment::wrap($form, 'photocopy1', 'photocopy2');
    }

}
