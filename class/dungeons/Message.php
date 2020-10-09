<?php //>

namespace dungeons;

class Message {

    private static $bundles = [];

    public static function defined(...$tokens) {
        foreach ($tokens as $token) {
            list($name, $key) = preg_split('/\./', $token, 2);

            if (key_exists($key, self::load($name))) {
                return $token;
            }
        }

        return null;
    }

    public static function get($token, $default = null) {
        list($name, $key) = preg_split('/\./', $token, 2);

        return self::load($name)[$key] ?? $default ?? "{{$token}}";
    }

    public static function load($name, $language = null) {
        if (!key_exists($name, self::$bundles)) {
            $path = 'message/' . ($language ?? constant('LANGUAGE')) . '/' . $name;
            $bundle = Resource::union("{$path}.php");

            if ($bundle) {
                $file = Resource::getDataFile($path);

                if ($file) {
                    $bundle = array_merge($bundle, json_decode(file_get_contents($file), true));
                }
            }

            self::$bundles[$name] = $bundle;
        }

        return self::$bundles[$name];
    }

}
