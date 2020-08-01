<?php //>

use dungeons\Config;
use dungeons\Message;

return new class() extends dungeons\web\backend\GetController {

    public function remix($styles, $list) {
        $data = array_pop($list);
        $fields = [];
        $labels = Message::load("module/{$data['module']}");
        $module = Config::load("module/{$data['module']}");
        $table = $this->table();

        foreach ($module['fields'] as $field) {
            $name = $field['name'];

            $field['label'] = $labels[$name] ?? "[{$name}]";
            $field['placeholder'] = @$labels["{$name}.placeholder"];
            $field['remark'] = @$labels["{$name}.remark"];

            if (isset($table->$name)) {
                $field['multilingual'] = $table->$name->multilingual();
            }

            $options = @$field['options'];

            if ($options) {
                $field['options'] = Message::load("options/{$options}");
            }

            $fields[] = $field;
        }

        array_splice($styles, 4, 0, $fields);

        return $styles;
    }

    protected function init() {
        $table = table('Block');

        $names = [
            'id',
            'page_id',
            'module',
            'name',
            'enable_time',
            'disable_time',
            'ranking',
        ];

        $this->table($table);
        $this->columns($table->getColumns($names));
    }

    protected function postprocess($form, $result) {
        $extra = json_decode($result['data']['extra'], true);

        if ($extra) {
            foreach ($extra as $name => $value) {
                $result['data'][$name] = $value;
            }
        }

        return $result;
    }

};
