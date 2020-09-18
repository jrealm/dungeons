<?php //>

use dungeons\Config;
use dungeons\utility\RSA;

return function ($number) {
    $data = [
        'cardNo' => $number,
        'randomStr' => md5(rand()),
    ];

    ksort($data);

    $dataStr = json_encode($data);
    $paytend = Config::load('paytend');

    $param = http_build_query([
        'agentId' => $paytend['agentId'],
        'reqData' => RSA::encrypt($dataStr, $paytend['publicKeyFile']),
        'signature' => md5($dataStr . $paytend['md5key']),
    ]);

    logger('card-query-raw')->info(json_encode($param));

    //--

    $response = post_content("{$paytend['url']}/api/mastercard/masterCardQuery.html", $param, 300);

    logger('card-query')->info($response);

    //--

    $response = json_decode($response, true);

    if (@$response['respCode'] !== '00') {
        logger('card-query')->error(json_encode($response, JSON_UNESCAPED_UNICODE));

        return false;
    }

    $response = RSA::decrypt($response['respData'], $paytend['privateKeyFile']);

    logger('card-query')->info($response);

    $response = json_decode($response, true);

    return [
        'card_no' => $number,
        'balance' => @$response['balance'] / 100,
        'status' => $response['auditStatus'],
        'message' => @$response['auditDescription'],
        'cardStatus' => $response['cardStatus'],
    ];
};
