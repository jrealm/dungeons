<?php //>

return new Twig\TwigFunction('i18n', function ($token) {
    return dungeons\Message::get($token);
});
