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

        $node = rtrim($this->getMenuName(), '/');

        if ($this->user()['id'] === 1) {
            $allow = null;
        } else {
            $allow = preg_split('/\|/', cfg("backend.{$node}"));
        }

        if ($allow === null || in_array($name, $allow)) {
            $data = $this->load($folder, $name);
        } else {
            $data = null;
        }

        if (!$data) {
            return ['error' => 'error.DataNotFound'];
        }

        return ['success' => true, 'data' => $data, 'prefix' => "{$this->category()}/{$folder}.{$name}"];
    }

}
