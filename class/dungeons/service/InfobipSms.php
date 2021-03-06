<?php //>

namespace dungeons\service;

class InfobipSms {

    public function execute($args) {
        $phone = $args['prefix'] . ltrim($args['phone'], '0');

        if ($args['key'] === '00000') {
            $response = '{"messages":[{"messageId":true}]}';
        } else {
            $data = json_encode(['messages' => [['destinations' => [['to' => $phone]], 'text' => $args['text']]]]);

            $ch = curl_init();

            curl_setopt_array($ch, [
                CURLOPT_URL => $args['url'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => [
                    "Authorization: App {$args['key']}",
                    'Content-Type: application/json',
                    'Accept: application/json'
                ]
            ]);

            $response = curl_exec($ch);

            curl_close($ch);
        }

        $result = json_decode($response, true);

        if (@$result['messages'][0]['messageId']) {
            model('SmsLog')->insert(['receiver' => $phone, 'content' => $args['text'], 'response' => $response]);

            return true;
        }

        return false;
    }

}
