<?php //>

use dungeons\Config;
use dungeons\utility\Fn;
use dungeons\utility\RSA;

return function ($number, $config = null) {
    $data = [
        'cardNo' => $number,
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

    logger('card-query-raw')->info($param);

    $response = Fn::http_post("{$paytend['url']}/api/mastercard/masterCardQuery.html", $param);

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
        'balance' => @$response['balance'] / 100,
        'status' => $response['auditStatus'], // 0:未送審  1:審核中  2:成功  3:拒絕
        'message' => @$response['auditDescription'],
        'cardStatus' => $response['cardStatus'], // 4:未激活  5:正常  6:掛失  7:註銷  8:凍結
    ];
};
