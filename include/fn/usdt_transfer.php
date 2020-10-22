<?php //>

use dungeons\utility\Fn;
use kornrunner\Ethereum\Transaction;

return function ($sender, $private, $receiver, $amount) {
    $nonce = Fn::eth_getTransactionCount($sender);

    if ($nonce === false) {
        return false;
    }

    $gasPrice = Fn::eth_gasPrice();

    if ($gasPrice === false) {
        return false;
    }

    $gasLimit = dechex(cfg('etherscan.gasLimit'));
    $contract = '0xdac17f958d2ee523a2206206994597c13d831ec7';

    $method = '0xa9059cbb';
    $address = str_pad(substr($receiver, 2), 64, '0', STR_PAD_LEFT);
    $value = str_pad(dechex($amount * 1000000), 64, '0', STR_PAD_LEFT);

    $transaction = new Transaction(dechex($nonce), dechex($gasPrice), $gasLimit, $contract, 0, "{$method}{$address}{$value}");

    //--

    $key = cfg('etherscan.key');
    $raw = '0x' . $transaction->getRaw(substr($private, 2));

    logger('usdt_transfer')->info($raw, $transaction->getInput());

    $content = @file_get_contents("https://api.etherscan.io/api?module=proxy&action=eth_sendRawTransaction&hex={$raw}&apikey={$key}");
    $response = json_decode($content, true);

    if (strpos(@$response['result'], '0x') === 0) {
        return model('Erc20Transaction')->insert([
            'hash' => $response['result'],
            'sender' => $sender,
            'receiver' => $receiver,
            'currency' => 'USDT',
            'amount' => $amount,
        ]);
    }

    return false;
};
