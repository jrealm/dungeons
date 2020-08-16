<?php //>

use dungeons\Config;

return new class() extends dungeons\web\backend\GetBundle {

    protected function init() {
        $this->category('config');
    }

    protected function load($folder, $name) {
        return Config::load($folder === 'base' ? $name : "{$folder}/{$name}");
    }

};
