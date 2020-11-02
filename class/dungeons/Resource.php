<?php //>

namespace dungeons;

class Resource {

    private static $resources = [];

    public static function find($path) {
        foreach (RESOURCE_FOLDERS as $folder) {
            $file = $folder . $path;

            if (file_exists($file)) {
                return $file;
            }
        }

        return false;
    }

    public static function getDataFile($path, $verify = true) {
        if (defined('APP_DATA')) {
            if (defined('CUSTOM_APP')) {
                $file = APP_DATA . CUSTOM_APP . '/' . $path;
            } else {
                $file = APP_DATA . $path;
            }

            if (!$verify || is_file($file)) {
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
                foreach ($nodes as $path => $node) {
                    $node['i18n'] = "menu/{$name}.{$path}";
                    $bundle[$path] = $node;
                }
            }
        }

        return $bundle;
    }

    public static function union($path) {
        $bundle = null;

        foreach (array_reverse(RESOURCE_FOLDERS) as $folder) {
            $data = self::load($folder . $path, false);

            if ($data) {
                $bundle = $bundle ? array_merge($bundle, $data) : $data;
            }
        }

        return $bundle;
    }

}
