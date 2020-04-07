<?php //>

return new class() extends dungeons\web\UserController {

    use dungeons\web\backend\Authorizer;

    public function __construct() {
        parent::__construct();

        $this->view('backend/index.twig');
    }

    public function available() {
        if ($this->method() === 'GET') {
            $pattern = preg_quote($this->name(), '/');

            return preg_match("/^{$pattern}(\/.+)?$/", $this->path());
        }

        return false;
    }

    protected function process($form) {
        $nodes = [];
        $menus = $this->loadMenus();

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

        return ['success' => true, 'nodes' => $this->filter($nodes)];
    }

    private function filter($nodes) {
        foreach ($nodes as $path => &$node) {
            if (@$node['nodes']) {
                $node['nodes'] = $this->filter($node['nodes']);

                if (!$node['nodes']) {
                    $node = null;
                }
            } else {
                if (!$this->hasPermission($path)) {
                    $node = null;
                }
            }
        }

        return array_filter($nodes);
    }

};
