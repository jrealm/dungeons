<?php //>

namespace dungeons\web\backend\block\item;

use dungeons\Config;
use dungeons\web\backend\BlankController as Controller;
use dungeons\web\backend\BlockForm;
use dungeons\web\backend\SubCreation;

class BlankController extends Controller {

    use BlockForm, SubCreation;

    protected function init() {
        $this->columns($this->table()->getColumns([
            'id',
            'block_id',
            'enable_time',
            'disable_time',
            'ranking',
        ]));
    }

    protected function process($form) {
        $result = parent::process($form);

        if (@$result['success']) {
            $table = $this->table();
            $block = $table->parent()->model()->get($this->args()[0]);
            $data = $result['data'];
            $parent = Config::load("module/{$block['module']}");
            $module = Config::load("sub-module/{$parent['sub-module']}");

            foreach ($module['fields'] as $field) {
                $value = @$field['default'];

                if ($value === null) {
                    continue;
                }

                $name = $field['name'];

                if (isset($table->{$name})) {
                    $field['multilingual'] = $table->{$name}->multilingual();
                }

                if (@$field['multilingual']) {
                    foreach (LANGUAGES as $language) {
                        $data["{$name}__{$language}"] = $value;
                    }
                } else {
                    $data[$name] = $value;
                }
            }

            $result['data'] = $data;
        }

        return $result;
    }

}
