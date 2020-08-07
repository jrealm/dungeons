<?php //>

namespace dungeons\cli;

use dungeons\Controller as AbstractController;

class Controller extends AbstractController {

    public function __construct() {
        parent::__construct();

        $this->view('empty.php');
    }

    public function available() {
        return ($this->method() === 'cli');
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
