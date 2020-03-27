<?php //>

use dungeons\Config;

return new class() extends dungeons\web\backend\GetBundle {

    protected function load($folder, $name) {
        return Config::load($folder === 'base' ? $name : "{$folder}/{$name}");
    }

};
