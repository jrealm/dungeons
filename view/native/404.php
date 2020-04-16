<?php //>

if (PHP_SAPI === 'cli') {
    echo "Controller \"{$controller->path()}\" not found.\n";
} else {
    header('HTTP/1.1 404 Not Found');
}
