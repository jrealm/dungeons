<?php //>

return new Twig\TwigFunction('datetime_format', function ($value) {
    return str_replace(['Y', 'm', 'd', 'H', 'i', 's'], ['YYYY', 'MM', 'DD', 'HH', 'mm', 'ss'], $value);
});
