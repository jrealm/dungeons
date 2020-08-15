<?php //>

use dungeons\Message;

return new class() extends dungeons\web\backend\GetBundle {

    protected function init() {
        if ($this->user()['id'] !== 1) {
            $folder = $this->args()[0];

            if ($folder === 'base') {
                $bundles = 'backend.i18n.bundles';
            } else {
                $bundles = "backend.i18n.{$folder}.bundles";
            }

            $this->allow(preg_split('/\|/', cfg($bundles)));
        }

        $this->category('message');
    }

    protected function load($folder, $name) {
        return Message::load($folder === 'base' ? $name : "{$folder}/{$name}");
    }

};
