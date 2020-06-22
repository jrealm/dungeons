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

        if (defined('APP_HOME')) {
            $path = APP_HOME . 'view/twig/';

            if (defined('CUSTOM_APP')) {
                $custom = $path . CUSTOM_APP . '/';

                if (is_dir($custom)) {
                    $paths[] = $custom;
                }
            }

            if (is_dir($path)) {
                $paths[] = $path;
            }
        }

        $paths[] = DUNGEONS . 'view/twig/';

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
