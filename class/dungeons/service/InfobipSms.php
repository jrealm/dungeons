<?php //>

namespace dungeons\service;

class InfobipSms {

    public function execute($args) {
        if ($args['prefix'] === '+886') {
            $args['phone'] = preg_replace('/^09([\d]{8})$/', '9$1', $args['phone']);
        }

        $phone = "{$args['prefix']}{$args['phone']}";
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

        $result = json_decode($response, true);

        if (@$result['messages'][0]['messageId']) {
            model('SmsLog')->insert(['receiver' => $phone, 'content' => $args['text'], 'response' => $response]);

            return true;
        }

        return false;
    }

}
