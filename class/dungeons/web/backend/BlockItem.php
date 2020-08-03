<?php //>

namespace dungeons\web\backend;

use dungeons\Config;
use dungeons\Message;

trait BlockItem {

    public function remix($styles, $list) {
        array_pop($list);
        $parent = array_pop($list);
        $sub = Config::load("module/{$parent['module']}")['sub-module'];

        $fields = [];
        $labels = Message::load("module/{$sub}");
        $module = Config::load("module/{$sub}");
        $table = $this->table();

        foreach ($module['fields'] as $field) {
            $name = $field['name'];

            $field['label'] = $labels[$name] ?? "[{$name}]";

            if (isset($table->$name)) {
                $field['multilingual'] = $table->$name->multilingual();
            }

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
