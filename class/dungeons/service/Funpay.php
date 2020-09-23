<?php //>

namespace dungeons\service;

use dungeons\utility\Fn;

class Funpay {

    public function execute($args) {
        $data = array_intersect_key($args, array_flip(['amount', 'info', 'orderid', 'phone', 'quota', 'redirect_url', 'remark', 'type', 'url', 'userid']));

        ksort($data);

        $sign = '';

        foreach ($data as $name => $value) {
            $sign = "{$sign}{$name}={$value}&";
        }

        $sign = "{$sign}key={$args['key']}";

        $data['sign'] = md5($sign);

        //--

        $request = json_encode($data);

        logger('funpay')->info($request);

        $response = Fn::http_post($args['location'], $data);

        logger('funpay')->info($response);

        //--

        if ($response === false) {
            logger('funpay-error')->info($request);

            return false;
        }

        $result = json_decode($response, true);

        if ($result) {
            $response = json_encode($result, JSON_UNESCAPED_UNICODE);
        }

        if (@$result['code'] !== 0) {
            logger('funpay-error')->info($response, $data);

            return null;
        }

        $result['request'] = $request;
        $result['response'] = $response;

        return $result;
    }

}
