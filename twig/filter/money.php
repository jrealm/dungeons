<?php //>

return new Twig\TwigFilter('money', function ($number, $decimals = 0) {
    if ($decimals && intval($number) == floatval($number)) {
        $decimals = 0;
    }

    return number_format($number, $decimals);
});
