<?php //>

namespace dungeons\service;

use dungeons\utility\Fn;

class EcPay {

    public static function checksum($data, $key, $iv) {
        unset($data['CheckMacValue']);

        ksort($data);

        $sign = 'HashKey=' . $key;

        foreach ($data as $name => $value) {
            $sign = "{$sign}&{$name}={$value}";
        }

        $sign = strtolower(urlencode($sign . '&HashIV=' . $iv));

        $sign = str_replace('%20', '+', $sign);
        $sign = str_replace('%21', '!', $sign);
        $sign = str_replace('%28', '(', $sign);
        $sign = str_replace('%29', ')', $sign);
        $sign = str_replace('%2a', '*', $sign);
        $sign = str_replace('%2d', '-', $sign);
        $sign = str_replace('%2e', '.', $sign);
        $sign = str_replace('%5f', '_', $sign);

        return strtoupper(hash('sha256', $sign));
    }

    public function execute($args) {
        $names = [
            'ChoosePayment',
            'EncryptType',
            'ItemName',
            'Language',
            'MerchantID',
            'MerchantTradeDate',
            'MerchantTradeNo',
            'PaymentType',
            'ReturnURL',
            'TotalAmount',
            'TradeDesc',
        ];

        switch (@$args['ChoosePayment']) {
        case 'ATM':
            $names[] = 'ClientRedirectURL';
            $names[] = 'ExpireDate';
            break;
        case 'CVS':
            $names[] = 'ClientRedirectURL';
            $names[] = 'StoreExpireDate';
            break;
        case 'Credit':
            $names[] = 'OrderResultURL';
            $names[] = 'UnionPay';
            break;
        default:
            return false;
        }

        //--

        $data = array_intersect_key($args, array_flip($names));

        $data['CheckMacValue'] = self::checksum($data, @$args['HashKey'], @$args['HashIV']);

        return $data;
    }

}
