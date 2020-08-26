<?php //>

return new Twig\TwigFilter('pathname', function ($path) {
    if (defined('FILES_HOME')) {
        return "/files/{$path}";
    }

    return APP_PATH . 'files/' . $path;
});
