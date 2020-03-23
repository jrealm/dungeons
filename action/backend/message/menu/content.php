<?php //>

use dungeons\Message;

return new class() extends dungeons\web\backend\GetBundle {

    protected function load($name) {
        return Message::load("menu/{$name}");
    }

};
