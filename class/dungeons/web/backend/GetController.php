<?php //>

namespace dungeons\web\backend;

use dungeons\web\BackendController;

class GetController extends BackendController {

    public function __construct() {
        parent::__construct();

        $this->view('backend/view.php');
    }

    public function available() {
        if ($this->method() === 'POST') {
            $pattern = preg_quote($this->name(), '/');

            return preg_match("/^{$pattern}[\w-]+$/", $this->path());
        }

        return false;
    }

    protected function process($form) {
        $data = $this->table()->model()->get($this->args()[0]);

        if (!$data) {
            return ['error' => 'error.DataNotFound'];
        }

        return ['success' => true, 'data' => $data];
    }

}
