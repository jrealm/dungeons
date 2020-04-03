<?php //>

namespace dungeons\web\backend;

use dungeons\web\BackendController;

abstract class GetBundle extends BackendController {

    public function __construct() {
        parent::__construct();

        $this->view('backend/view-bundle.php');
    }

    public function available() {
        if ($this->method() === 'POST') {
            $pattern = preg_quote($this->name(), '/');

            return preg_match("/^{$pattern}[\w]+\/[\w-]+$/", $this->path());
        }

        return false;
    }

    protected function getMenuName() {
        return preg_replace('/^\/backend\/(.+\/)[\w-]+$/', '$1', $this->path());
    }

    abstract protected function load($folder, $name);

    protected function process($form) {
        list($folder, $name) = $this->args();

        $data = $this->load($folder, $name);

        if (!$data) {
            return ['error' => 'error.DataNotFound'];
        }

        $styles = $data['@'] ?? [];

        unset($data['@']);

        return ['success' => true, 'data' => $data, 'styles' => $styles];
    }

}
