<?php //>

return function ($address) {
    $key = cfg('etherscan.key');
    $contract = '0xdac17f958d2ee523a2206206994597c13d831ec7';
    $content = file_get_contents("https://api.etherscan.io/api?module=account&action=tokenbalance&contractaddress={$contract}&address={$address}&tag=latest&apikey={$key}");
    $response = json_decode($content, true);

    return @$response['status'] ? ($response['result'] / 1000000) : false;
};
