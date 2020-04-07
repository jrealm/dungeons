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
            $permission = @$menu['group'] ? $node : $menu['parent'];

            if (true) {
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
        if (!$this->permissions) {
        }

        return $this->permissions;
    }

}
