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

    protected $action;

    public function action() {
        return $this->action;
    }

    public function run() {
        define('ACTION_NAME', $this->action->name());

        $this->action->execute();
    }

}
