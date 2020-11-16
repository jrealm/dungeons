<?php //>

use Monolog\ErrorHandler;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Handler\PlainTextHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

define('DUNGEONS', dirname(__DIR__) . '/');

require 'functions.php';
require APP_HOME . 'config.php';

if (defined('CUSTOM_APP')) {
    $folders = [APP_HOME . CUSTOM_APP . '/', APP_HOME];
} else {
    $folders = [APP_HOME];
}

foreach (PACKAGES as $package) {
    $folders[] = APP_HOME . 'vendor/' . $package . '/';
}

spl_autoload_register(function ($name) use ($folders) {
    $file = 'class/' . str_replace('\\', '/', $name) . '.php';

    foreach ($folders as $folder) {
        $path = $folder . $file;

        if (is_file($path)) {
            isolate_require($path);
            break;
        }
    }
}, true, true);

$folders[] = DUNGEONS;

define('RESOURCE_FOLDERS', $folders);

if (PHP_SAPI === 'cli') {
    $handler = PlainTextHandler::class;
    $loader = 'cli.php';
} else {
    if (strtolower(@$_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        define('AJAX', true);

        $handler = JsonResponseHandler::class;
    } else {
        $handler = PrettyPageHandler::class;
    }

    $loader = 'web.php';
}

if (defined('DEBUG') && DEBUG) {
    (new Run())->prependHandler(new $handler())->register();
}

ErrorHandler::register(logger('ERROR'));

require $loader;
