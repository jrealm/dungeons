<?php //>

namespace dungeons\web\backend;

use dungeons\Config;
use dungeons\Message;

trait BlockForm {

    public function remix($styles, $list) {
        $moduleName = @array_pop($list)['module'];

        if ($moduleName) {
            $module = Config::load("module/{$moduleName}");
        } else {
            $moduleName = @array_pop($list)['module'];

            if (!$moduleName) {
                return $styles;
            }

            $moduleName = Config::load("module/{$moduleName}")['sub-module'];
            $module = Config::load("sub-module/{$moduleName}");
        }

        $fields = [];
        $labels = Message::load("module/{$moduleName}");
        $table = $this->table();

        foreach ($module['fields'] as $field) {
            $name = $field['name'];

            $field['label'] = $labels[$name] ?? i18n("block.{$name}", $name);
            $field['placeholder'] = @$labels["{$name}.placeholder"];
            $field['remark'] = @$labels["{$name}.remark"];

            if (isset($table->{$name})) {
                $field['multilingual'] = $table->{$name}->multilingual();
            }

            $options = @$field['options'];

            if (is_array($options)) {
                $field['options'] = $options;
            } else if (is_string($options)) {
                $field['options'] = Message::load("options/{$options}");
            }

            $fields[] = $field;
        }

        array_splice($styles, -3, 0, $fields);

        return $styles;
    }

    protected function postprocess($form, $result) {
        $extra = json_decode($result['data']['extra'], true);

        if ($extra) {
            $result['data'] = array_merge($result['data'], $extra);
        }

        return $result;
    }

}
