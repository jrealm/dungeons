<?php //>

namespace dungeons\web\backend;

use dungeons\web\BackendController;

class BlankController extends BackendController {

    public function __construct($tableName = null) {
        parent::__construct();

        if ($tableName) {
            $this->table(table($tableName));
        }

        $this->view('backend/new.php');
    }

    public function remix($styles, $list) {
        return $styles;
    }

    protected function process($form) {
        $data = [];

        foreach ($this->table()->getColumns() as $name => $column) {
            $data[$name] = $column->default();
        }

        $relation = $this->table()->getMasterRelation();

        if ($relation) {
            $data[$relation['column']->name()] = $this->args()[0];
        }

        return ['success' => true, 'data' => $data];
    }

}
