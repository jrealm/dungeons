<?php //>

namespace dungeons\web\backend;

use dungeons\web\BackendController;

class InsertController extends BackendController {

    use Validator, Wrapper;

    public function __construct($tableName = null) {
        parent::__construct();

        if ($tableName) {
            $this->table(table($tableName));
        }

        $this->generator('generate');
        $this->validationView('backend/validation.php');
        $this->view('backend/insert-success.php');
    }

    protected function process($form) {
        $data = $this->table()->model()->insert($form);

        if (!$data) {
            return ['error' => 'error.InsertFailed'];
        }

        return ['success' => true, 'data' => $data];
    }

    protected function wrap() {
        $form = $this->wrapModel(parent::wrap());
        $relation = $this->table()->getMasterRelation();

        if ($relation) {
            $form[$relation['column']->name()] = $this->args()[0];
        }

        return $form;
    }

}
