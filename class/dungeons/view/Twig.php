<?php //>

namespace dungeons\view;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use dungeons\Resource;

class Twig {

    private $view;

    public function __construct($view) {
        $this->view = $view;
    }

    public function render($action, $form, $result) {
        $paths = [];

        if (defined('APP_HOME')) {
            $path = APP_HOME . 'view/twig/';

            if (is_dir($path)) {
                $paths[] = $path;
            }
        }

        $paths[] = DUNGEONS . 'view/twig/';

        $twig = new Environment(new FilesystemLoader($paths));

        $twig->registerUndefinedFilterCallback(function ($name) {
            return Resource::load("twig/filter/{$name}.php") ?: false;
        });

        $twig->registerUndefinedFunctionCallback(function ($name) {
            return Resource::load("twig/function/{$name}.php") ?: false;
        });

        echo $twig->render($this->view, [
            'action' => $action,
            'form' => $form,
            'result' => $result,
        ]);
    }

}
