<?php //>

namespace dungeons;

class Config {

    private static $bundles = [];

    public static function get($token, $default = null) {
        list($name, $key) = preg_split('/\./', $token, 2);

        return self::load($name)[$key] ?? $default;
    }

    public static function load($name) {
        if (!key_exists($name, self::$bundles)) {
            $path = "config/{$name}";
            $bundle = Resource::union("{$path}.php");

            if ($bundle) {
                $file = Resource::getDataFile($path);

                if ($file) {
                    foreach (json_decode(file_get_contents($file), true) as $key => $value) {
                        if (key_exists($key, $bundle)) {
                            if (is_array($value) && is_array($bundle[$key])) {
                                $bundle[$key] = array_merge($bundle[$key], $value);
                            } else {
                                $bundle[$key] = $value;
                            }
                        }
                    }
                }
            }

            self::$bundles[$name] = $bundle;
        }

        return self::$bundles[$name];
    }

}
