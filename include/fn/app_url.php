<?php //>

return function () {
    $protocol = $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';

    return $protocol . $_SERVER['HTTP_HOST'] . APP_ROOT;
};
