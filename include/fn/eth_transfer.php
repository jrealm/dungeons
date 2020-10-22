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
    $value = dechex($amount * 1000000000000000000);

    $transaction = new Transaction(dechex($nonce), dechex($gasPrice), $gasLimit, $receiver, $value);

    //--

    $key = cfg('etherscan.key');
    $raw = '0x' . $transaction->getRaw(substr($private, 2));

    logger('eth_transfer')->info($raw, $transaction->getInput());

    $content = @file_get_contents("https://api.etherscan.io/api?module=proxy&action=eth_sendRawTransaction&hex={$raw}&apikey={$key}");
    $response = json_decode($content, true);

    if (strpos(@$response['result'], '0x') === 0) {
        return model('Erc20Transaction')->insert([
            'hash' => $response['result'],
            'sender' => $sender,
            'receiver' => $receiver,
            'currency' => 'ETH',
            'amount' => $amount,
        ]);
    }

    return false;
};
