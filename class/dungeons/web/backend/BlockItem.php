<?php //>

namespace dungeons\web\backend;

use dungeons\{Config,Message};

trait BlockItem {

    public function remix($styles, $list) {
        array_pop($list);
        $parent = array_pop($list);
        $sub = Config::load("module/{$parent['module']}")['sub-module'];

        $fields = [];
        $labels = Message::load("module/{$sub}");
        $module = Config::load("module/{$sub}");

        foreach ($module['fields'] as $field) {
            $field['label'] = $labels[$field['name']] ?? "[{$field['name']}]";

            $fields[] = $field;
        }

        array_splice($styles, 2, 0, $fields);

        return $styles;
    }

    protected function init() {
        $table = table('BlockItem');

        $names = [
            'id',
            'block_id',
            'enable_time',
            'disable_time',
            'ranking',
        ];

        $this->table($table);
        $this->columns($table->getColumns($names));
    }

}
