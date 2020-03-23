<?php //>

namespace dungeons\web;

class Session {

    public static function get($name, $default = null) {
        return $_SESSION[$name] ?? $default;
    }

    public static function remove($name) {
        if (key_exists($name, $_SESSION)) {
            unset($_SESSION[$name]);
        }
    }

    public static function set($name, $value) {
        $_SESSION[$name] = $value;
    }

}
