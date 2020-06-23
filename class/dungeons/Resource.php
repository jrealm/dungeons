<?php //>

namespace dungeons;

class Resource {

    private static $resources = [];

    public static function find($path) {
        if (defined('APP_HOME')) {
            if (defined('CUSTOM_APP')) {
                $file = APP_HOME . CUSTOM_APP . '/' . $path;

                if (file_exists($file)) {
                    return $file;
                }
            }

            $file = APP_HOME . $path;

            if (file_exists($file)) {
                return $file;
            }
        }

        $file = DUNGEONS . $path;

        return file_exists($file) ? $file : false;
    }

    public static function getDataFile($path) {
        if (defined('APP_DATA')) {
            if (defined('CUSTOM_APP')) {
                $file = APP_DATA . CUSTOM_APP . '/' . $path;

                if (is_file($file)) {
                    return $file;
                }
            }

            $file = APP_DATA . $path;

            if (is_file($file)) {
                return $file;
            }
        }

        return null;
    }

    public static function load($path, $resolve = true) {
        if ($resolve) {
            $file = self::find($path);
        } else {
            $file = is_file($path) ? $path : false;
        }

        if ($file === false) {
            return null;
        }

        if (!key_exists($file, self::$resources)) {
            self::$resources[$file] = isolate_require($file);
        }

        return self::$resources[$file];
    }

    public static function loadMenu($names) {
        $bundle = [];

        if (is_string($names)) {
            $names = explode('|', $names);
        }

        foreach ($names as $name) {
            $nodes = self::load("menu/{$name}.php");

            if ($nodes) {
                $messages = Message::load("menu/{$name}");

                foreach ($nodes as $path => $node) {
                    $node['title'] = $messages[$path] ?? "<{$path}>";
                    $bundle[$path] = $node;
                }
            }
        }

        return $bundle;
    }

    public static function union($path) {
        $base = self::load(DUNGEONS . $path, false);

        if (defined('APP_HOME')) {
            $extend = self::load(APP_HOME . $path, false);

            if (defined('CUSTOM_APP')) {
                $custom = self::load(APP_HOME . CUSTOM_APP . '/' . $path, false);

                if ($custom) {
                    $extend = $extend ? array_merge($extend, $custom) : $custom;
                }
            }
        } else {
            $extend = null;
        }

        if ($base) {
            return $extend ? array_merge($base, $extend) : $base;
        } else {
            return $extend;
        }
    }

}
