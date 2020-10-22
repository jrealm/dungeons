<?php //>

return function () {
    $key = cfg('etherscan.key');
    $content = file_get_contents("https://api.etherscan.io/api?module=proxy&action=eth_blockNumber&apikey={$key}");
    $response = json_decode($content, true);

    return strpos(@$response['result'], '0x') === 0 ? hexdec($response['result']) : false;
};
