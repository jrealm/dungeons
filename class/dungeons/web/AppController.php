<?php //>

namespace dungeons\web;

use dungeons\{Config,Resource};

class AppController extends MemberController {

    public function available() {
        return ($this->method() === 'POST' && $this->name() === $this->path());
    }

    protected function postprocess($form, $result) {
        $menus = Resource::loadMenu(Config::get('app.menus'));
        $path = substr($this->name(), 1);
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
