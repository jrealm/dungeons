<?php //>

use dungeons\Message;

return new class() extends dungeons\web\backend\GetBundle {

    protected function init() {
        $this->category('message');
    }

    protected function load($folder, $name) {
        return Message::load($folder === 'base' ? $name : "{$folder}/{$name}");
    }

};
