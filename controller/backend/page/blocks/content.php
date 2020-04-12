<?php //>

use dungeons\{Config,Message};

return new class() extends dungeons\web\backend\GetController {

    public function remix($styles, $list) {
        $data = array_pop($list);
        $fields = [];
        $labels = Message::load("module/{$data['module']}");
        $module = Config::load("module/{$data['module']}");

        foreach ($module['fields'] as $field) {
            $field['label'] = $labels[$field['name']] ?? "[{$field['name']}]";
            $field['placeholder'] = @$labels["{$field['name']}.placeholder"];
            $field['remark'] = @$labels["{$field['name']}.remark"];

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
