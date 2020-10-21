<?php //>

namespace dungeons\cli;

use dungeons\Controller as AbstractController;

class Controller extends AbstractController {

    private $handle;

    public function __construct() {
        parent::__construct();

        $this->view('empty.php');
    }

    public function available() {
        return ($this->method() === 'cli');
    }

    protected function acquireLock() {
        $filename = APP_DATA . str_replace('/', '.', $this->name());

        $this->handle = fopen($filename, 'w');

        return flock($this->handle, LOCK_EX | LOCK_NB);
    }

    protected function wrap() {
        $form = [];

        foreach (array_splice($_SERVER['argv'], 2) as $arg) {
            if ($arg[0] === '-') {
                $name = ltrim($arg, '-');
                $pos = strpos($name, '=');

                if ($pos === false) {
                    $value = true;
                } else {
                    $value = substr($name, $pos + 1);
                    $name = substr($name, 0, $pos);
                }

                $this->{$name}($value);
            } else {
                $form[] = $arg;
            }
        }

        return $form;
    }

}
