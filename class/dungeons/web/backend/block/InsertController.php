<?php //>

namespace dungeons\web\backend\block;

use dungeons\Config;
use dungeons\web\backend\InsertController as Controller;
use dungeons\web\backend\SubCreation;

class InsertController extends Controller {

    use SubCreation;

    protected function preprocess($form) {
        $extra = [];
        $module = Config::load("module/{$form['module']}");
        $table = $this->table();

        foreach ($module['fields'] as $field) {
            $name = $field['name'];
            $value = @$field['default'];

            if ($value === null) {
                continue;
            }

            if (isset($table->{$name})) {
                $table->{$name}->default($value);
            } else {
                if (@$field['multilingual']) {
                    foreach (LANGUAGES as $language) {
                        $extra["{$name}__{$language}"] = $value;
                    }
                } else {
                    $extra[$name] = $value;
                }
            }
        }

        if ($extra) {
            $form['extra'] = json_encode($extra, JSON_UNESCAPED_UNICODE);
        }

        return $form;
    }

}
