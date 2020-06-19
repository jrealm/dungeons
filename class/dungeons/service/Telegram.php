<?php //>

namespace dungeons\service;

class Telegram {

    public function execute($args) {
        $text = urlencode($args['text']);

        @file_get_contents("https://api.telegram.org/bot{$args['bot']}/sendMessage?chat_id={$args['group']}&text={$text}");
    }

}