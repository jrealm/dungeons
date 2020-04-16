<?php //>

namespace dungeons\cli;

use dungeons\Controller as AbstractController;

class Controller extends AbstractController {

    public function available() {
        return ($this->method() === 'cli');
    }

    protected function wrap() {
        return array_splice($_SERVER['argv'], 2);
    }

}
