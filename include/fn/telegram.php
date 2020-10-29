<?php //>

use dungeons\Config;

return function ($text, $config = 'telegram') {
    $telegram = Config::load($config);
    $telegram['text'] = $text;

    return execute($telegram);
};
