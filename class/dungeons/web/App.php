<?php //>

namespace dungeons\web;

use dungeons\App as AbstractApp;
use dungeons\{Config,Resource};

class App extends AbstractApp {

    protected function __construct() {
        if (session_id() === '') {
            if (defined('APP_NAME')) {
                session_name(APP_NAME);
            }

            session_start();
        }

        define('APP_PATH', dirname($_SERVER['SCRIPT_NAME']) . '/');

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

        $this->action = $this->find($info[3] ?? '/', $_SERVER['REQUEST_METHOD']);
    }

    protected function find($path, $method) {
        $args = [];
        $current = '';
        $tokens = preg_split('/\//', $path, 0, PREG_SPLIT_NO_EMPTY);

        $candidates = [['/', 'index', $tokens]];

        while ($tokens) {
            $found = false;
            $token = array_shift($tokens);
            $name = "{$current}/{$token}";

            if (Resource::find("action{$name}.php")) {
                $found = true;
                $candidates[] = [$name, '', array_merge($args, $tokens)];
            }

            if ($tokens && Resource::find("action{$name}/")) {
                $found = true;

                if (Resource::find("action{$name}/content.php")) {
                    $candidates[] = ["{$name}/", 'content', array_merge($args, $tokens)];
                }
            }

            if ($found) {
                $current = $name;
            } else {
                $args[] = $token;
            }
        }

        while ($candidates) {
            list($name, $file, $args) = array_pop($candidates);

            $action = Resource::load("action{$name}{$file}.php");

            if ($action instanceof Action) {
                $action->args($args)->method($method)->name($name)->path($path);

                if ($action->available()) {
                    return $action;
                }
            }
        }

        return new Action(['path' => $path, 'view' => '404.php']);
    }

}
