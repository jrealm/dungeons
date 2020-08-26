<?php //>

return new Twig\TwigFilter('img', function ($image, $width = 0) {
    if (preg_match('/^data:/', $image)) {
        return $image;
    }

    $root = defined('FILES_HOME') ? '/' : APP_PATH;

    if ($width) {
        $folder = defined('FILES_HOME') ? FILES_HOME : (APP_HOME . 'www/files/');
        $thumb = "{$image}_{$width}";

        if (!file_exists($folder . $thumb)) {
            exec("convert \"{$folder}{$image}\" -resize {$width}\\> \"{$folder}{$thumb}\"");
        }

        return "{$root}files/{$thumb}";
    }

    return "{$root}files/{$image}";
});
