<?php //>

namespace dungeons\web\backend;

use dungeons\{Config,Resource};

trait Authorizer {

    private $menus;
    private $permissions;

    public function hasPermission($node) {
        $menu = @$this->loadMenus()[$node];

        if ($menu) {
            $user = $this->user();

            $permissions = $this->loadPermissions($user['group_id']);
            $path = @$menu['group'] ? $node : $menu['parent'];

            if (@$permissions[$path][$menu['tag']] || $user['id'] === 1) {
                return $menu;
            }
        }

        return false;
    }

    private function loadMenus() {
        if (!$this->menus) {
            $this->menus = Resource::loadMenu(Config::get('backend.menus'));
        }

        return $this->menus;
    }

    private function loadPermissions($groupId) {
        if (!$this->permissions && defined('APP_DATA')) {
            $file = APP_DATA . 'permission/' . $groupId;

            if (is_file($file)) {
                $this->permissions = json_decode(file_get_contents($file), true);
            }
        }

        return $this->permissions;
    }

}
