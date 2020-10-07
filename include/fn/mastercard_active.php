<?php //>

use dungeons\Config;
use dungeons\utility\Fn;
use dungeons\utility\RSA;

return function ($number, $info, $config = null) {
    $folder = defined('FILES_HOME') ? FILES_HOME : (APP_HOME . 'www/files/');
    $image = "{$folder}{$info['photocopy1']}";

    @exec("convert \"{$image}\" -resize 720\\> \"{$image}_720\""); // 縮圖

    $data = [
        'cardNo' => $number,
        'mobile' => $info['mobile'],
        'lastName' => base64_encode($info['last_name']),
        'firstName' => base64_encode($info['first_name']),
        'email' => $info['mail'],
        'dateOfBirth' => $info['birthday'],
        'nationality' => $info['nationality_code'],
        'sex' => $info['sex'],
        'countryCode' => $info['country_code'],
        'town' => base64_encode($info['town']),
        'address' => base64_encode($info['address']),
        'postCode' => $info['post_code'],
        'idnoType' => 2, // 護照
        'idno' => $info['id_number'],
        'idPhotoData' => base64_encode(file_get_contents(file_exists("{$image}_720") ? "{$image}_720" : $image)),
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

    logger('card-active-raw')->info($param);

    $response = Fn::http_post("{$paytend['url']}/api/mastercard/masterCardActive.html", $param);

    logger('card-active')->info($response);

    //--

    $response = json_decode($response, true);

    if (@$response['respCode'] !== '00') {
        logger('card-active')->error(json_encode($response, JSON_UNESCAPED_UNICODE));

        return false;
    }

    $response = RSA::decrypt($response['respData'], $paytend['privateKeyFile']);

    logger('card-active')->info($response);

    $response = json_decode($response, true);

    switch (@$response['auditStatus']) {
    case 1: // 審核中
    case 2: // 成功
        break;
    default:
        return null; // 失敗
    }

    return [
        'status' => $response['auditStatus'],
        'message' => $response['errMsg'],
    ];
};
