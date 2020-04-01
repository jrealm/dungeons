<?php //>

namespace dungeons\web\backend;

use dungeons\web\UserController;

class DeleteController extends UserController {

    public function __construct() {
        parent::__construct();

        $this->confirm('backend/confirm-delete.twig');
        $this->view('backend/delete-success.php');
    }

    public function available() {
        if ($this->method() === 'POST') {
            $pattern = preg_quote($this->name(), '/');

            return preg_match("/^{$pattern}\/[\/\w-]+$/", $this->path());
        }

        return false;
    }

    protected function process($form) {
        if (empty($form['confirm'])) {
            return [
                'path' => preg_replace('/^\/backend\/(.+)$/', '$1', $this->path()),
                'view' => $this->confirm(),
            ];
        }

        $args = $this->args();
        $model = $this->table()->model();
        $data = null;

        foreach ($args as $id) {
            $data = $model->delete($id);

            if (is_null($data)) {
                break;
            }

            if ($data === false) {
                return ['error' => 'error.DeleteFailed'];
            }
        }

        if (is_null($data)) {
            return ['error' => 'error.DataNotFound'];
        }

        return ['success' => true];
    }

    protected function wrap() {
        return $this->wrapGet();
    }

}
