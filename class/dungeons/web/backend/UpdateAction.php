<?php //>

namespace dungeons\web\backend;

use dungeons\web\UserAction;

class UpdateAction extends UserAction {

    use Validator;

    public function __construct() {
        parent::__construct();

        $this->generator('regenerate');
        $this->validationView('backend/validation.php');
        $this->view('backend/update-success.php');
    }

    public function available() {
        if ($this->method() === 'POST') {
            return preg_match("#^{$this->name()}/[^/]+$#", $this->path());
        }

        return false;
    }

    protected function process($form) {
        $args = $this->args();
        $form['id'] = (count($args) === 1) ? $args[0] : null;

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
