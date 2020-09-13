<?php //>

namespace dungeons\web\backend;

use dungeons\web\BackendController;

class UpdateController extends BackendController {

    use Validator, Wrapper;

    public function __construct($tableName = null) {
        parent::__construct();

        if ($tableName) {
            $this->table(table($tableName));
        }

        $this->generator('regenerate');
        $this->validationView('backend/validation.php');
        $this->view('backend/update-success.php');
    }

    public function available() {
        if ($this->method() === 'POST') {
            $pattern = preg_quote($this->name(), '/');

            return preg_match("/^{$pattern}\/[\w-]+$/", $this->path());
        }

        return false;
    }

    protected function process($form) {
        $form['id'] = $this->args()[0];

        $data = $this->table()->model()->update($form);

        if ($data === null) {
            return ['error' => 'error.DataNotFound'];
        }

        if ($data === false) {
            if ($this->table()->versionable()) {
                return ['error' => 'error.DataOverdue'];
            }

            return ['error' => 'error.UpdateFailed'];
        }

        return ['success' => true, 'data' => $data];
    }

    protected function wrap() {
        return $this->wrapModel(parent::wrap());
    }

}
