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
        return array_splice($_SERVER['argv'], 2);
    }

}
