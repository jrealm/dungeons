<?php //>

return new Twig\TwigFilter('img', function ($image, $width = 0) {
    if (preg_match('/^data:/', $image)) {
        return $image;
    }

    if ($width) {
        $folder = APP_HOME . 'www/files/';
        $thumb = "{$image}_{$width}";

        if (!file_exists($folder . $thumb)) {
            exec("convert \"{$folder}{$image}\" -resize {$width}\\> \"{$folder}{$thumb}\"");
        }

        return APP_PATH . 'files/' . $thumb;
    }

    return APP_PATH . 'files/' . $image;
});
