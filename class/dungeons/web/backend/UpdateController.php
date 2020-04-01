<?php //>

namespace dungeons\web\backend;

use dungeons\web\UserController;

class UpdateController extends UserController {

    use Validator, Wrapper;

    public function __construct() {
        parent::__construct();

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

        if (is_null($data)) {
            return ['error' => 'error.DataNotFound'];
        }

        if ($data === false) {
            return ['error' => 'error.UpdateFailed'];
        }

        return ['success' => true, 'data' => $data];
    }

}
