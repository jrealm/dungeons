<?php //>

namespace dungeons\service;

use dungeons\utility\RSA;

class Lcpay {

    // https://lcpay.gitbook.io/payment/

    public function execute($args) {
        $data = array_intersect_key($args, array_flip([
            'attach',
            'bankSegment',
            'billNumber',
            'cardType',
            'clientId',
            'deviceModel',
            'gameName',
            'gameNotifyUrl',
            'gameUserId',
            'ip',
            'money',
            'paymentMethod',
            'productName',
            'trxDateTime',
            'userType',
            'version',
        ]));

        ksort($data);

        $sign = '';

        foreach ($data as $name => $value) {
            $sign = "{$sign}{$name}={$value}&";
        }

        $sign = "{$sign}key={$args['key']}";

        $data['sign'] = md5($sign);

        //--

        ksort($data);

        $text = '';

        foreach ($data as $name => $value) {
            $text = $text . ($text ? '&' : '') . "{$name}={$value}";
        }

        $ciphertext = RSA::encrypt($text, $args['pub_key_file']);

        //--

        $data['ciphertext'] = $ciphertext;

        $request = json_encode($data);

        //--

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query(['ciphertext' => $ciphertext]),
            ],
        ];

        $context = stream_context_create($options);

        $response = @file_get_contents($args['url'], false, $context);

        if ($response === false) {
            logger('lcpay-error')->info($request);

            return false;
        }

        //--

        $result['request'] = $request;
        $result['response'] = $response;

        return $result;
    }

}
