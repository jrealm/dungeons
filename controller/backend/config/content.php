<?php //>

use dungeons\Config;

return new class() extends dungeons\web\backend\GetBundle {

    protected function init() {
        if ($this->user()['id'] !== 1) {
            $this->allow(preg_split('/\|/', cfg('backend.cfg.bundles')));
        }
    }

    protected function load($folder, $name) {
        return Config::load($folder === 'base' ? $name : "{$folder}/{$name}");
    }

};
