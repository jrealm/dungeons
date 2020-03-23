<?php //>

use dungeons\Message;

return new Twig\TwigFunction('i18n', function ($token) {
    return Message::get($token);
});
