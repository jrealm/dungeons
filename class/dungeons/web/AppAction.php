<?php //>

namespace dungeons\web;

use dungeons\Config;
use dungeons\Resource;

class AppAction extends MemberAction {

    public function available() {
        return ($this->method() === 'POST' && $this->name() === $this->path());
    }

    protected function postprocess($form, $result) {
        $menus = Resource::loadMenu(explode('|', Config::get('app.menus')));
        $path = preg_replace('/\/(.*)/', '$1', $this->name());
        $node = @$menus[$path];

        $result['title'] = $node['title'];

        $breadcrumb = [];
        $visible = null;

        while ($node) {
            if (!$visible) {
                $node['path'] = $path;
                $result['menu'] = $path;
                $visible = @$node['ranking'];
            }

            $breadcrumb[] = $node;

            $path = $node['parent'];
            $node = $path ? $menus[$path] : null;
        }

        $result['breadcrumb'] = array_reverse($breadcrumb);

        return $result;
    }

}
