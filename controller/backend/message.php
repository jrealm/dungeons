<?php //>

use dungeons\Message;

return new class() extends dungeons\web\backend\ListBundle {

    protected function init() {
        $folder = $this->args()[0];

        if ($folder === 'base') {
            $this->folder('message/' . constant('LANGUAGE'));
            $this->labels(Message::load('message'));

            $bundles = 'backend.i18n.bundles';
        } else {
            $this->folder('message/' . constant('LANGUAGE') . '/' . $folder);
            $this->labels(Message::load("message-{$folder}"));

            $bundles = "backend.i18n.{$folder}.bundles";
        }

        if ($this->user()['id'] !== 1) {
            $this->allow(preg_split('/\|/', cfg($bundles)));
        }
    }

};
