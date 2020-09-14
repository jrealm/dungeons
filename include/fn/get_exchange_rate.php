<?php //>

$exchange = function ($from, $to) use (&$exchange) {
    if ($from === 'TWD') {
        $rate = model('ExchangeRate')->find(['base_id' => 4, 'currency' => $to]);

        if ($rate) {
            return 1 / ($rate['sell'] + $rate['sell_profit']);
        }

        return false;
    }

    if ($to === 'TWD') {
        $rate = model('ExchangeRate')->find(['base_id' => 4, 'currency' => $from]);

        if ($rate) {
            return $rate['buy'] + $rate['buy_profit'];
        }

        return false;
    }

    $rate1 = $exchange($from, 'TWD');

    if ($rate1 === false) {
        return false;
    }

    $rate2 = $exchange('TWD', $to);

    if ($rate2 === false) {
        return false;
    }

    return $rate1 * $rate2;
};

return $exchange;
