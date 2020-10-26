<?php //>

use dungeons\db\column\Text;
use dungeons\utility\Fn;

return new class() extends dungeons\web\backend\GetController {

    protected function init() {
        $table = table('MasterCard');
        $table->status->readonly(true);
        $table->add('username', 'member.username');
        $table->add('balance', Text::class)->pseudo(true)->readonly(true);

        $this->table($table);
    }

    protected function postprocess($form, $result) {
        $data = &$result['data'];
        $response = Fn::mastercard_query($data['card_number']);

        if ($response) {
            $data['currency'] = '€';
            $data['balance'] = $response['balance'];

            if ($data['status'] !== $response['status']) {
                $data['status'] = $response['auditStatus'];

                $this->table()->model()->update($data);
            }
        } else {
            $data['balance'] = i18n('error.ConnectFailed');
        }

        return $result;
    }

};
