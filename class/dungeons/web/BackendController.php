<?php //>

namespace dungeons\web;

class BackendController extends UserController {

    use backend\Authorizer;

    public function createBreadcrumbs($list) {
        $breadcrumbs = [];
        $menus = $this->loadMenus();
        $menu = $this->menu();
        $node = $this->node();
        $visible = null;

        while ($menu) {
            if (!$visible) {
                $data = array_pop($list);

                if ($data) {
                    if (@$data['.title']) {
                        $menu['title'] = $data['.title'];
                    }

                    if (@$menu['pattern']) {
                        $node = render($menu['pattern'], $data);
                    }
                }

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
            $menu = $this->hasPermission($node);

            if ($menu) {
                $this->menu($menu)->node($node);

                return true;
            }

            header('HTTP/1.1 403 Forbidden');
        }

        return false;
    }

    protected function getMenuName() {
        return preg_replace('/^\/backend\/(.+)$/', '$1', $this->name());
    }

}
