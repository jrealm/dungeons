<?php //>

use dungeons\Config;
use dungeons\Message;

return new class() extends dungeons\web\backend\UpdateController {

    protected function init() {
        $table = table('MemberPassportAuth');
        $table->id->required(false);
        $table->member_id->required(false);

        $this->table($table);
    }

    protected function preprocess($form) {
        $form['approver'] = $this->user()['username'];
        $form['approve_time'] = date(cfg('system.timestamp'));

        return $form;
    }

    protected function postprocess($form, $result) {
        $data = $result['data'];
        $member = model('Member')->get($data['member_id']);

        $mailer = Config::load('gmail');
        $mailer['to'] = $member['mail'];

        if ($data['status'] === 2) {
            $content = Message::load("template/passport-auth-rejected", $data['language']);
            $content['rejection'] = $data['rejection'];
        } else {
            $content = Message::load("template/passport-auth-success", $data['language']);
        }

        execute(array_merge($mailer, $content));

        return $result;
    }

    protected function validate($form) {
        $errors = parent::validate($form);

        switch (@$form['status']) {
        case 2:
            if (@$form['rejection'] === null) {
                $errors[] = ['name' => 'rejection', 'type' => 'required'];
            }
            break;
        }

        return $errors;
    }

};
