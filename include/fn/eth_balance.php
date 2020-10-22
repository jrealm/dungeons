<?php //>

return function ($address) {
    $key = cfg('etherscan.key');
    $content = @file_get_contents("https://api.etherscan.io/api?module=account&action=balance&address={$address}&tag=latest&apikey={$key}");
    $response = json_decode($content, true);

    return @$response['status'] ? ($response['result'] / 1000000000000000000) : false;
};
