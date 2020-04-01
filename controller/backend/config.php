<?php //>

use dungeons\Message;

return new class() extends dungeons\web\backend\ListBundle {

    protected function init() {
        $folder = $this->args()[0];

        if ($folder === 'base') {
            $this->folder('config');
            $this->labels(Message::load('config'));
        } else {
            $this->folder("config/{$folder}");
            $this->labels(Message::load("config-{$folder}"));
        }
    }

};
