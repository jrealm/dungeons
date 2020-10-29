<?php //>

return new class() extends dungeons\web\backend\GetController {

    protected function init() {
        $table = table('MemberPassportAuth');
        $table->add('username', 'member.username');

        $this->table($table);
    }

    protected function postprocess($form, $result) {
        $table = $this->table();

        switch ($result['data']['status']) {
        case 1:
            $table->approver->invisible(true);
            $table->approve_time->invisible(true);
            break;
        case 2:
            $table->language->invisible(true);
            break;
        case 3:
            $table->language->invisible(true);
            $table->rejection->invisible(true);
            break;
        }

        return $result;
    }

};
