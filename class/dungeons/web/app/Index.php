<?php //>

namespace dungeons\web\app;

use dungeons\Resource;
use dungeons\web\MemberController;

class Index extends MemberController {

    public function available() {
        return ($this->method() === 'GET');
    }

    protected function init() {
        $this->view('index.twig');
    }

    protected function process($form) {
        $nodes = [];
        $menus = Resource::loadMenu(cfg('app.menus'));

        foreach ($menus as $path => &$menu) {
            if (empty($menu['ranking'])) {
                continue;
            }

            $parent = $menu['parent'];

            if (key_exists($parent, $menus)) {
                if (key_exists('nodes', $menus[$parent])) {
                    $menus[$parent]['nodes'][$path] = &$menu;
                } else {
                    $menus[$parent]['nodes'] = [$path => &$menu];
                }
            } else {
                $nodes[$path] = &$menu;
            }
        }

        return ['success' => true, 'nodes' => $nodes];
    }

}
