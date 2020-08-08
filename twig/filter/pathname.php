<?php //>

return new Twig\TwigFilter('pathname', function ($path) {
    return APP_PATH . 'files/' . $path;
});
