<?php //>

use dungeons\Config;

return new Twig\TwigFunction('cfg', function ($token) {
    return Config::get($token);
});
