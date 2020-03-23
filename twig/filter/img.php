<?php //>

return new Twig\TwigFilter('img', function ($image) {
    if (preg_match('/^data:/', $image)) {
        return $image;
    }

    return APP_PATH . 'files/' . $image;
});
