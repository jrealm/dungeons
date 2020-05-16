<?php //>

namespace dungeons\web;

use dungeons\Config;
use dungeons\Resource;

class AppController extends MemberController {

    private $menus;

    public function available() {
        return ($this->method() === 'POST' && $this->name() === $this->path());
    }

    public function createBreadcrumbs() {
        $breadcrumbs = [];
        $menus = $this->loadMenus();
        $menu = $this->menu();
        $node = $this->node();
        $visible = null;

        while ($menu) {
            if (!$visible) {
                $menu['path'] = $node;
                $visible = @$menu['ranking'];
            }

            $breadcrumbs[] = $menu;
            $node = $menu['parent'];
            $menu = @$menus[$node];
        }

        return array_reverse($breadcrumbs);
    }

    protected function authorize() {
        if (parent::authorize()) {
            $node = $this->getMenuName();
            $menus = $this->loadMenus();
            $menu = @$menus[$node];

            if ($menu) {
                $this->menu($menu)->node($node);
            }

            return true;
        }

        return false;
    }

    protected function getMenuName() {
        return substr($this->name(), 1);
    }

    private function loadMenus() {
        if (!$this->menus) {
            $this->menus = Resource::loadMenu(Config::get('app.menus'));
        }

        return $this->menus;
    }

}
