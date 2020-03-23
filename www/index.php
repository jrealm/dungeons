<?php //>

define('APP_HOME', dirname(__DIR__) . '/');

require '../vendor/autoload.php';

dungeons\App::getInstance()->run();
