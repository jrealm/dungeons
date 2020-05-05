<?php //>

namespace dungeons\web\backend;

use dungeons\web\BackendController;

class DeleteController extends BackendController {

    public function __construct($tableName = null) {
        parent::__construct();

        if ($tableName) {
            $this->table(table($tableName));
        }

        $this->confirm('backend/confirm-delete.twig');
        $this->view('backend/delete-success.php');
    }

    public function available() {
        if ($this->method() === 'POST') {
            $pattern = preg_quote($this->name(), '/');

            return preg_match("/^{$pattern}(\/[\/\w-]+)?$/", $this->path());
        }

        return false;
    }

    protected function process($form) {
        $args = $this->args();

        if (!$args) {
            $args = @$form['args'];

            if (!$args || !is_array($args)) {
                return ['error' => 'error.DataNotFound'];
            }
        }

        if (empty($form['confirm'])) {
            return [
                'args' => $args,
                'view' => $this->confirm(),
            ];
        }

        $model = $this->table()->model();
        $list = [];

        foreach ($args as $id) {
            $data = $model->delete($id);

            if (is_null($data)) {
                break;
            }

            if ($data === false) {
                return ['error' => 'error.DeleteFailed'];
            }

            $list[] = $data;
        }

        if (!$list) {
            return ['error' => 'error.DataNotFound'];
        }

        return ['success' => true, 'list' => $list];
    }

}
