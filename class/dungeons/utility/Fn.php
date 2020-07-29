<?php //>

namespace dungeons\utility;

use dungeons\Resource;

class Fn {

    private static $functions = [];

    public static function __callStatic($name, $arguments) {
        if (!key_exists($name, self::$functions)) {
            self::$functions[$name] = Resource::load("include/fn/{$name}.php");
        }

        return call_user_func_array(self::$functions[$name], $arguments);
    }

}
