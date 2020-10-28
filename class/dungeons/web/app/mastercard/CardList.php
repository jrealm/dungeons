<?php //>

namespace dungeons\web\app\mastercard;

use dungeons\utility\Fn;
use dungeons\web\AppController;

class CardList extends AppController {

    protected function process($form) {
        $member = $this->member();

        $model = model('MasterCard');
        $cards = $model->query(['member_id' => $member['id']]);

        foreach ($cards as &$data) {
            $response = Fn::mastercard_query($data['card_number']);

            if ($response) {
                $data['currency'] = '€';
                $data['balance'] = $response['balance'];

                if ($data['status'] !== $response['status']) {
                    $data['status'] = $response['status'];

                    $model->update($data);
                }
            } else {
                $data['balance'] = i18n('error.ConnectFailed');
            }
        }

        return ['success' => true, 'cards' => $cards];
    }

}
