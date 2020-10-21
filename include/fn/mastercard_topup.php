<?php //>

use dungeons\Config;
use dungeons\utility\Fn;
use dungeons\utility\RSA;

return function ($orderNo, $number, $amount, $config = null) {
    $data = [
        'cardNo' => $number,
        'orderNo' => $orderNo,
        'amount' => $amount * 100,
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

    logger('card-topup-raw')->info($param);

    $response = Fn::http_post("{$paytend['url']}/api/mastercard/masterCardTopup.html", $param);

    logger('card-topup')->info($response);

    //--

    $response = json_decode($response, true);

    if (@$response['respCode'] !== '00') {
        logger('card-topup')->error(json_encode($response, JSON_UNESCAPED_UNICODE));

        return false;
    }

    $response = RSA::decrypt($response['respData'], $paytend['privateKeyFile']);

    logger('card-topup')->info($response);

    $response = json_decode($response, true);

    switch (@$response['topupStatus']) {
    case 1: // 成功
    case 3: // 處理中
        break;
    default:
        return null; // 失敗
    }

    return [
        'request' => json_encode($data, JSON_UNESCAPED_UNICODE),
        'response' => json_encode($response, JSON_UNESCAPED_UNICODE),
        'status' => $response['topupStatus'],
        'message' => $response['errMsg'],
    ];
};
