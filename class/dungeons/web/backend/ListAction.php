<?php //>

namespace dungeons\web\backend;

use dungeons\web\UserAction;

class ListAction extends UserAction {

    public function __construct() {
        parent::__construct();

        $this->view('backend/list.php');
    }

    protected function process($form) {
        $page = $this->positive_integer(@$form['p'], 1);
        $size = $this->positive_integer(@$form['s'], 10);
        $orders = preg_split('/[, ]/', @$form['o'], 0, PREG_SPLIT_NO_EMPTY);

        $model = $this->table()->model();

        $count = $model->count($form);
        $data = $count ? $model->query($form, $orders ?: true, $size, $page) : [];

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
        return $this->wrapGet();
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
