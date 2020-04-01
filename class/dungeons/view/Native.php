<?php //>

namespace dungeons\view;

use dungeons\Resource;

class Native {

    private $view;

    public function __construct($view) {
        $this->view = $view;
    }

    public function render($controller, $form, $result) {
        require Resource::find("view/native/{$this->view}");
    }

}
