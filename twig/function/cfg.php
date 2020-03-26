<?php //>

return new Twig\TwigFunction('cfg', function ($token) {
    return dungeons\Config::get($token);
});
