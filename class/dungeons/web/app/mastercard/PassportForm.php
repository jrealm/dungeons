<?php //>

namespace dungeons\web\app\mastercard;

use dungeons\helper\MastercardHelper;
use dungeons\Message;
use dungeons\web\AppController;

class PassportForm extends AppController {

    use MastercardHelper;

    protected function process($form) {
        $data = $this->getPassportAuth(true);

        $countries = model('Country')->query();

        $options = [
            'sex' => Message::load('options/sex'),
        ];

        return [
            'success' => true,
            'data' => $data,
            'countries' => $countries,
            'options' => $options,
        ];
    }

}
