<?php //>

namespace dungeons\service;

class Funpay {

    public function execute($args) {
        $data = array_intersect_key($args, array_flip(['amount', 'orderid', 'phone', 'remark', 'type', 'url', 'userid']));

        ksort($data);

        $sign = '';

        foreach ($data as $name => $value) {
            $sign = "{$sign}{$name}={$value}&";
        }

        $sign = "{$sign}key={$args['key']}";

        $data['sign'] = md5($sign);

        $request = json_encode($data);

        //--

        $ch = curl_init($args['location']);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);

        $response = curl_exec($ch);

        curl_close($ch);

        //--

        if ($response === false) {
            return false;
        }

        $result = json_decode($response, true);

        if (@$result['code'] !== 0) {
            logger('funpay-error')->info($response, $data);

            return null;
        }

        $result['request'] = $request;
        $result['response'] = $response;

        return $result;
    }

}
