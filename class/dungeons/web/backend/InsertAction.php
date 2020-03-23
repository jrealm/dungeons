<?php //>

namespace dungeons\web\backend;

use dungeons\web\UserAction;

class InsertAction extends UserAction {

    use Validator;

    public function __construct() {
        parent::__construct();

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

}
