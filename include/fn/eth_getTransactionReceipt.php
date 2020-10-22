<?php //>

return function ($hash) {
    $key = cfg('etherscan.key');
    $content = @file_get_contents("https://api.etherscan.io/api?module=proxy&action=eth_getTransactionReceipt&txhash={$hash}&apikey={$key}");
    $response = json_decode($content, true);

    return is_array(@$response['result']) ? hexdec($response['result']['status']) : false;
};
