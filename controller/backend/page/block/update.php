<?php //>

use dungeons\Attachment;
use dungeons\Config;
use dungeons\utility\ValueObject;

return new class() extends dungeons\web\backend\UpdateController {

    protected function init() {
        $this->table(table('Block'));
    }

    protected function preprocess($form) {
        $module = $this->module();

        if ($module) {
            $extra = [];
            $table = $this->table();

            foreach ($module['fields'] as $field) {
                $name = $field['name'];

                if (empty($table->{$name})) {
                    $value = @$form[$name];

                    if ($value instanceof Attachment) {
                        $value->save();
                        $value = strval($value);
                    }

                    $extra[$name] = $value;
                }
            }

            if ($extra) {
                $form['extra'] = json_encode($extra, JSON_UNESCAPED_UNICODE);
            }
        }

        return $form;
    }

    protected function validate($form) {
        $errors = parent::validate($form);
        $module = $this->module();

        if ($module) {
            $table = $this->table();

            foreach ($module['fields'] as $field) {
                $name = $field['name'];

                if (isset($table->{$name})) {
                    $field['multilingual'] = $table->{$name}->multilingual();
                }

                if (@$field['multilingual']) {
                    foreach (LANGUAGES as $lang) {
                        $errors = $this->validateField($errors, $field, $form, $name, $lang);
                    }
                } else {
                    $errors = $this->validateField($errors, $field, $form, $name, null);
                }
            }
        }

        return $errors;
    }

    protected function wrap() {
        $form = parent::wrap();
        $module = Config::load("module/{$form['module']}");

        if ($module) {
            foreach ($module['fields'] as $field) {
                switch ($field['type']) {
                case 'file':
                case 'image':
                    $form = Attachment::wrap($form, $field['name']);
                    break;
                }
            }

            $this->module($module);
        }

        return $form;
    }

    private function validateField($errors, $field, $form, $name, $language) {
        if ($language) {
            $name = "{$name}__{$language}";
        }

        $value = @$form[$name];

        if ($value === null) {
            if (@$field['required']) {
                $errors[] = ['name' => $name, 'type' => 'required'];
            }
        } else {
            $options = new ValueObject(['validation' => $field['type']]);

            switch ($field['type']) {
            case 'date':
            case 'time':
            case 'timestamp':
                $options->pattern(Config::get("system.{$field['type']}"));
                break;
            case 'image':
                $options->mimeType('image\/[\w]+');
                break;
            case 'double':
            case 'email':
            case 'file':
            case 'integer':
            case 'url':
                break;
            default:
                $options = null;
            }

            if ($options) {
                $type = validate($value, $options);

                if ($type) {
                    $errors[] = ['name' => $name, 'type' => $type];
                }
            }
        }

        return $errors;
    }

};
