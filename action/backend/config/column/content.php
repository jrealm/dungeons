<?php //>

use dungeons\Config;

return new class() extends dungeons\web\backend\GetBundle {

    protected function load($name) {
        return Config::load("column/{$name}");
    }

};
