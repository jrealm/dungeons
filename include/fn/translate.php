<?php //>

return function ($text, $from, $to) {
    $key = cfg('system.googleTranslateKey');
    $text = urlencode($text);

    $url = "https://translation.googleapis.com/language/translate/v2/?q={$text}&source={$from}&target={$to}&key={$key}";

    $result = json_decode(file_get_contents($url), true);

    return @$result['data']['translations'][0]['translatedText'];
};
