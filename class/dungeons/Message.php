<?php //>

namespace dungeons;

class Message {

    private static $bundles = [];

    public static function get($token) {
        list($name, $key) = preg_split('/\./', $token, 2);

        return self::load($name)[$key] ?? "{{$token}}";
    }

    public static function load($name) {
        if (!key_exists($name, self::$bundles)) {
            $path = 'message/' . constant('LANGUAGE') . '/' . $name;
            $bundle = Resource::union("{$path}.php");

            if ($bundle) {
                $file = Resource::getDataFile($path);

                if ($file) {
                    foreach (json_decode(file_get_contents($file), true) as $key => $value) {
                        if (key_exists($key, $bundle)) {
                            $bundle[$key] = $value;
                        }
                    }
                }
            }

            self::$bundles[$name] = $bundle;
        }

        return self::$bundles[$name];
    }

}
