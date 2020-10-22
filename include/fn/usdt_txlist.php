<?php //>

return function ($from, $to) {
    $key = cfg('etherscan.key');
    $contract = '0xdac17f958d2ee523a2206206994597c13d831ec7';
    $content = @file_get_contents("https://api.etherscan.io/api?module=account&action=txlist&address={$contract}&startblock={$from}&endblock={$to}&sort=asc&apikey={$key}");
    $response = json_decode($content, true);

    return @$response['status'] ? $response['result'] : false;
};
