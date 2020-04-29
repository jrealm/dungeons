<?php //>

namespace dungeons\web\backend;

use dungeons\web\BackendController;

class ListController extends BackendController {

    public function __construct($tableName = null) {
        parent::__construct();

        if ($tableName) {
            $this->table(table($tableName));
        }

        $this->view('backend/list.php');
    }

    public function remix($styles, $list) {
        return $styles;
    }

    protected function preprocess($form) {
        $relation = $this->table()->getMasterRelation();

        if ($relation) {
            $form[$relation['column']->name()] = $this->args()[0];
        }

        return $form;
    }

    protected function process($form) {
        $conditions = [];

        foreach ($this->filters() ?? [] as $name => $column) {
            $from = @$form[$name];
            $to = @$form["-{$name}"];

            if ($from === null) {
                if ($to === null) {
                    continue;
                } else {
                    $from = $to;
                    $to = null;
                }
            }

            switch ($column->searchStyle()) {
            case 'like':
                $conditions[] = $column->like("%{$from}%", true);
                break;
            case 'between':
                if ($to !== null) {
                    $conditions[] = $column->between($from, $to);
                    break;
                }
            default:
                $conditions[] = $column->equal($from);
            }
        }

        $page = $this->positive_integer(@$form['p'], 1);
        $size = $this->positive_integer(@$form['s'], 10);
        $orders = preg_split('/[, ]/', @$form['o'], 0, PREG_SPLIT_NO_EMPTY);

        $model = $this->table()->model();

        $count = $model->count($conditions);
        $data = $count ? $model->query($conditions, $orders ?: true, $size, $page): [];

        return [
            'success' => true,
            'count' => $count,
            'data' => $data,
            'page' => $page,
            'size' => $size,
            'orders' => $orders,
        ];
    }

    protected function wrap() {
        $form = $this->wrapGet();

        foreach ($this->filters() ?? [] as $name => $column) {
            foreach ([$name, "-{$name}"] as $token) {
                $value = @$form[$token];

                if ($value !== null && validate($value, $column)) {
                    unset($form[$token]);
                }
            }
        }

        return $form;
    }

    private function positive_integer($value, $default) {
        if (is_scalar($value)) {
            $value = intval($value);

            if ($value > 0) {
                return $value;
            }
        }

        return $default;
    }

}
