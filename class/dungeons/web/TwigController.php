<?php //>

namespace dungeons\web;

use dungeons\Resource;

class TwigController extends Controller {

    public function available() {
        $path = $this->path();
        $view = ($path === '/') ? 'index.twig' : "{$path}.twig";

        if (Resource::find("view/twig/{$view}")) {
            $this->view($view);

            return true;
        }

        return false;
    }

}
