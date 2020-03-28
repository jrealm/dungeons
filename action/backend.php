<?php //>

use dungeons\{Config,Resource};

return new class() extends dungeons\web\UserAction {

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
        $names = explode('|', Config::get('backend.menus'));
        $nodes = [];
        $menus = Resource::loadMenu($names);

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
            } else if (in_array($path, $names)) {
                $nodes[$path] = &$menu;
            }
        }

        return [
            'success' => true,
            'nodes' => $nodes,
        ];
    }

};
