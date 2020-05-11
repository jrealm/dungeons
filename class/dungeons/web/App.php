<?php //>

namespace dungeons\web;

use dungeons\App as AbstractApp;
use dungeons\Config;

class App extends AbstractApp {

    protected function __construct() {
        if (session_id() === '') {
            if (defined('APP_NAME')) {
                session_name(APP_NAME);
            }

            session_start();
        }

        define('APP_PATH', preg_replace('/^(.*\/)[^\/]+$/', '$1', $_SERVER['SCRIPT_NAME']));

        $languages = Config::get('system.supportedLanguages');

        preg_match("/^(\/({$languages}))?(\/.*)?$/", $_SERVER['PATH_INFO'], $info);

        if ($info[2]) {
            define('APP_ROOT', APP_PATH . "{$info[2]}/");
            define('LANGUAGE', $info[2]);
        } else {
            define('APP_ROOT', APP_PATH);
            define('LANGUAGE', Config::get('system.language'));
        }

        define('REMOTE_ADDR', $_SERVER['REMOTE_ADDR']);

        $this->controller = $this->find(@$info[3], $_SERVER['REQUEST_METHOD']);

        if ($this->controller === null) {
            $this->controller = new Controller(['path' => $info[3], 'view' => '404.php']);
        }
    }

}
