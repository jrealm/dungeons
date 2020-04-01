<?php //>

namespace dungeons\web\backend;

use dungeons\web\UserController;

class BlankController extends UserController {

    public function __construct() {
        parent::__construct();

        $this->view('backend/new.php');
    }

    protected function process($form) {
        $data = [];

        foreach ($this->table()->getColumns() as $name => $column) {
            $data[$name] = $column->default();
        }

        return ['success' => true, 'data' => $data];
    }

}
