<?php //>

namespace dungeons\web;

trait TwigView {

    private $view;

    public function view(...$arguments) {
        if (func_num_args()) {
            $this->view = $arguments[0];

            return $this;
        }

        if ($this->view === null) {
            $this->view = substr($this->path(), 1) . '.twig';
        }

        return $this->view;
    }

}
