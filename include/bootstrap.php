<?php //>

use Monolog\ErrorHandler;
use Whoops\Handler\{JsonResponseHandler,PlainTextHandler,PrettyPageHandler};
use Whoops\Run;
use dungeons\Resource;

define('DUNGEONS', dirname(__DIR__) . '/');

require 'functions.php';

if (defined('APP_HOME')) {
    require APP_HOME . 'config.php';

    spl_autoload_register(function ($name) {
        $file = APP_HOME . 'class/' . str_replace('\\', '/', $name) . '.php';

        if (is_file($file)) {
            isolate_require($file);
        }
    });
}

ErrorHandler::register(logger('ERROR'));

call_user_func(function() {
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

    require $loader;
});
