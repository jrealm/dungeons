<?php //>

return new Twig\TwigFunction('i18n', function ($token, $default = null) {
    return dungeons\Message::get($token, $default);
});
