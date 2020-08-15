<?php //>

return new class() extends dungeons\web\backend\GetController {

    use dungeons\web\backend\Authorizer;

    public function remix($styles, $list) {
        $nodes = [];
        $menus = $this->loadMenus();

        foreach ($menus as $path => &$menu) {
            $parent = $menu['parent'];

            if (key_exists($parent, $menus)) {
                $tag = @$menu['tag'];

                if ($tag) {
                    $name = @$menu['group'] ? $path : $parent;

                    if (!key_exists('tags', $menus[$name])) {
                        $menus[$name]['tags'] = [];
                    }

                    if ($tag !== 'system') {
                        if (!in_array($tag, $menus[$name]['tags'])) {
                            $menus[$name]['tags'][] = $tag;
                        }
                    }

                    if ($name === $parent) {
                        continue;
                    }
                }

                if (key_exists('nodes', $menus[$parent])) {
                    $menus[$parent]['nodes'][$path] = &$menu;
                } else {
                    $menus[$parent]['nodes'] = [$path => &$menu];
                }
            } else {
                $nodes[$path] = &$menu;
            }
        }

        $styles[] = [
            'label' => i18n('table/Group.permissions'),
            'name' => 'permissions',
            'options' => $nodes,
            'type' => 'checkbox-tree',
        ];

        return $styles;
    }

    protected function init() {
        $this->table(table('Group'));
    }

    protected function postprocess($form, $result) {
        $result['data']['permissions'] = $this->loadPermissions($result['data']['id']);

        return $result;
    }

};
