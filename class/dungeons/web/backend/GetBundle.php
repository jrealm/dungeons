<?php //>

namespace dungeons\web\backend;

use dungeons\web\UserAction;

abstract class GetBundle extends UserAction {

    public function __construct() {
        parent::__construct();

        $this->view('backend/view-bundle.php');
    }

    public function available() {
        if ($this->method() === 'POST') {
            return preg_match("#^{$this->name()}[^/]+$#", $this->path());
        }

        return false;
    }

    abstract protected function load($name);

    protected function process($form) {
        $args = $this->args();
        $data = (count($args) === 1) ? $this->load($args[0]) : null;

        if (!$data) {
            return ['error' => 'error.DataNotFound'];
        }

        $styles = $data['@'] ?? [];

        unset($data['@']);

        return ['success' => true, 'data' => $data, 'styles' => $styles];
    }

}
