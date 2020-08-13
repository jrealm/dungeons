<?php //>

namespace dungeons\cli;

use dungeons\App as AbstractApp;

class App extends AbstractApp {

    protected function __construct() {
        $languages = cfg('system.supportedLanguages');

        preg_match("/^(\/({$languages}))?(\/.*)?$/", @$_SERVER['argv'][1], $info);

        define('LANGUAGE', @$info[2] ? $info[2] : cfg('system.language'));
        define('LANGUAGES', preg_split('/\|/', $languages));

        $this->controller = $this->find(@$info[3], PHP_SAPI);

        if ($this->controller === null) {
            $this->controller = new Controller(['path' => @$info[3], 'view' => '404.php']);
        }
    }

}
