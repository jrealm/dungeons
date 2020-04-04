<?php //>

use dungeons\Message;

return new class() extends dungeons\web\backend\ListBundle {

    protected function init() {
        $folder = $this->args()[0];

        if ($folder === 'base') {
            $this->folder('message/' . constant('LANGUAGE'));
            $this->labels(Message::load('message'));
        } else {
            $this->folder('message/' . constant('LANGUAGE') . '/' . $folder);
            $this->labels(Message::load("message-{$folder}"));
        }
    }

};
