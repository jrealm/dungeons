<?php //>

use dungeons\Config;
use dungeons\utility\Fn;
use dungeons\utility\RSA;

return function ($orderNo, $config = null) {
    $data = [
        'orderNo' => $orderNo,
        'randomStr' => md5(rand()),
    ];

    ksort($data);

    $dataStr = json_encode($data);
    $paytend = Config::load($config ?: 'paytend');

    $param = http_build_query([
        'agentId' => $paytend['agentId'],
        'reqData' => RSA::encrypt($dataStr, $paytend['publicKeyFile']),
        'signature' => md5($dataStr . $paytend['md5key']),
    ]);

    //--

    logger('card-confirm-raw')->info($param);

    $response = Fn::http_post("{$paytend['url']}/api/mastercard/topupOrderQuery.html", $param);

    logger('card-confirm')->info($response);

    //--

    $response = json_decode($response, true);

    if (@$response['respCode'] !== '00') {
        logger('card-confirm')->error(json_encode($response, JSON_UNESCAPED_UNICODE));

        return false;
    }

    $response = RSA::decrypt($response['respData'], $paytend['privateKeyFile']);

    logger('card-confirm')->info($response);

    $response = json_decode($response, true);

    return [
        'status' => $response['topupStatus'],
        'message' => $response['errMsg'],
    ];
};
