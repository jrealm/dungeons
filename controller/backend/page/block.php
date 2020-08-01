<?php //>

use dungeons\Config;

return new class() extends dungeons\web\backend\ListController {

    use dungeons\web\backend\SubList;

    protected function init() {
        $table = table('Block');
        $table->add('item_count', 'item.count');

        $names = [
            'module',
            'name',
            'item_count',
            'enable_time',
            'disable_time',
            'ranking',
        ];

        $this->table($table);
        $this->columns($table->getColumns($names));
    }

    protected function postprocess($form, $result) {
        if (@$result['success']) {
            foreach ($result['data'] as &$data) {
                $module = Config::load("module/{$data['module']}");

                if (!@$module['sub-module']) {
                    unset($data['item_count']);
                }
            }
        }

        return $result;
    }

};
