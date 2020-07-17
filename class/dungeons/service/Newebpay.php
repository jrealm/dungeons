<?php //>

namespace dungeons\service;

class Newebpay {

    public function execute($args) {
        $fields = [
            'MerchantID',
            'RespondType',
            'TimeStamp',
            'Version',
            'LangType',
            'MerchantOrderNo',
            'Amt',
            'ItemDesc',
            'TradeLimit',
            'CREDIT',
            'ReturnURL',
            'NotifyURL',
            'Email',
        ];

        $data = array_intersect_key($args, array_flip($fields));
        $info = $this->encrypt($data, $args['HashKey'], $args['HashIV']);
        $hash = strtoupper(hash('sha256', "HashKey={$args['HashKey']}&{$info}&HashIV={$args['HashIV']}"));

        return [
            'MerchantID' => $args['MerchantID'],
            'TradeInfo' => $info,
            'TradeSha' => $hash,
            'Version' => $args['Version'],
            'url' => $args['url'],
        ];
    }

    private function encrypt($parameter, $key, $iv) {
        $data = http_build_query($parameter);
        $length = strlen($data);
        $pad = 32 - ($length % 32);

        $data = $data . str_repeat(chr($pad), $pad);

        return trim(bin2hex(openssl_encrypt($data, 'aes-256-cbc', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv)));
    }

}
