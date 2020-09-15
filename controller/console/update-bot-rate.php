<?php //>

// php index.php /console/update-bot-rate

return new class() extends dungeons\cli\Controller {

    protected function process($form) {
        $url = 'https://rate.bot.com.tw/xrt/flcsv/0/day';
        $content = file_get_contents($url);
        $model = model('ExchangeRate');
        $rates = [];
        $twd = model('Currency')->find(['code' => 'TWD']);

        foreach (explode("\r\n", $content) as $index => $line) {
            if ($index && $line) {
                $values = explode(',', $line);

                $rates[$values[0]] = $values;
            }
        }

        foreach ($model->query(['base_id' => $twd['id'], 'auto_modify' => true]) as $rate) {
            $values = @$rates[$rate['currency']];

            if (!is_null($values)) {
                $rate['buy'] = $values[2];
                $rate['sell'] = $values[12];

                $model->update($rate);
            }
        }

        return ['success' => true];
    }

};
