<?php //>

namespace dungeons\view;

use dungeons\Resource;
use Twig\Environment;
use Twig\Extension\StringLoaderExtension;
use Twig\Extra\String\StringExtension;
use Twig\Loader\FilesystemLoader;

class Twig {

    private $view;

    public function __construct($view) {
        $this->view = $view;
    }

    public function render($controller, $form, $result) {
        $paths = [];

        foreach (RESOURCE_FOLDERS as $folder) {
            $path = $folder . 'view/twig/';

            if (is_dir($path)) {
                $paths[] = $path;
            }
        }

        $twig = new Environment(new FilesystemLoader($paths));

        $twig->addExtension(new StringExtension());
        $twig->addExtension(new StringLoaderExtension());

        $twig->registerUndefinedFilterCallback(function ($name) {
            return Resource::load("twig/filter/{$name}.php") ?: false;
        });

        $twig->registerUndefinedFunctionCallback(function ($name) {
            return Resource::load("twig/function/{$name}.php") ?: false;
        });

        echo $twig->render($this->view, [
            'controller' => $controller,
            'form' => $form,
            'result' => $result,
        ]);
    }

}
