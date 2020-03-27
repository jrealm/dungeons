<?php //>

namespace dungeons;

class Resource {

    private static $resources = [];

    public static function find($path) {
        if (defined('APP_HOME')) {
            $file = APP_HOME . $path;

            if (file_exists($file)) {
                return $file;
            }
        }

        $file = DUNGEONS . $path;

        return file_exists($file) ? $file : false;
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
        $extend = defined('APP_HOME') ? self::load(APP_HOME . $path, false) : null;

        if ($base) {
            return $extend ? array_merge($base, $extend) : $base;
        } else {
            return $extend;
        }
    }

}
