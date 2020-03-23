<?php //>

return new Twig\TwigFunction('datetime_format', function ($value) {
    return str_replace(['Y', 'm', 'd'], ['YYYY', 'MM', 'DD'], $value);
});
