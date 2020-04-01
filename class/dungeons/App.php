<?php //>

namespace dungeons;

abstract class App {

    private static $instance;

    public static function getInstance() {
        return self::$instance;
    }

    public static function init() {
        if (self::$instance) {
            return;
        }

        self::$instance = new static();
    }

    protected $controller;

    public function controller() {
        return $this->controller;
    }

    public function run() {
        define('CONTROLLER_NAME', $this->controller->name());

        $this->controller->execute();
    }

}
