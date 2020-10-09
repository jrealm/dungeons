<?php //>

namespace dungeons\web\backend\block;

use dungeons\Config;
use dungeons\web\backend\ListController as Controller;
use dungeons\web\backend\SubList;

class ListController extends Controller {

    use SubList;

    protected function init() {
        $table = $this->table();
        $table->add('item_count', 'item.count');

        $this->columns($table->getColumns([
            'module',
            'name',
            'item_count',
            'enable_time',
            'disable_time',
            'ranking',
        ]));
    }

    protected function postprocess($form, $result) {
        foreach ($result['data'] as &$data) {
            $module = Config::load("module/{$data['module']}");

            if (!@$module['sub-module']) {
                unset($data['item_count']);
            }
        }

        return $result;
    }

}
