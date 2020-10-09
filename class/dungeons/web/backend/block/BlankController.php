<?php //>

namespace dungeons\web\backend\block;

use dungeons\Config;
use dungeons\web\backend\BlankController as Controller;
use dungeons\web\backend\BlockForm;
use dungeons\web\backend\SubCreation;

class BlankController extends Controller {

    use BlockForm, SubCreation;

    protected function init() {
        $this->table()->module->blankStyle('select');

        $this->validationView('backend/validation.php');
    }

    protected function process($form) {
        $result = parent::process($form);

        if (@$result['success']) {
            if (@$form['module']) {
                $table = $this->table();
                $table->module->disabled(true);

                $data = $result['data'];
                $data['module'] = $form['module'];

                $module = Config::load("module/{$data['module']}");

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

                $this->columns($table->getColumns(['module', 'name', 'enable_time', 'disable_time', 'ranking']));
            } else {
                $this->button([
                    'class' => cfg('backend.new.next.button'),
                    'i18n' => 'backend.new.next',
                    'method' => 'new',
                    'ranking' => 200,
                ]);

                $this->columns($this->table()->getColumns(['module']));
            }
        }

        return $result;
    }

    protected function validate($form) {
        $errors = parent::validate($form);

        if (@$form['form-id'] && @$form['module'] === null) {
            $errors[] = ['name' => 'module', 'type' => 'required'];
        }

        return $errors;
    }

}
