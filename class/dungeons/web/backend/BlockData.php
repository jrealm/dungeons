<?php //>

namespace dungeons\web\backend;

use dungeons\Attachment;
use dungeons\Config;
use dungeons\utility\ValueObject;

trait BlockData {

    protected function preprocess($form) {
        $extra = [];
        $module = $this->module();
        $table = $this->table();

        foreach ($module['fields'] as $field) {
            $name = $field['name'];

            if (isset($table->{$name})) {
                continue;
            }

            if (@$field['multilingual']) {
                foreach (LANGUAGES as $language) {
                    $extra = $this->packField($extra, $form, $name, $language);
                }
            } else {
                $extra = $this->packField($extra, $form, $name, null);
            }
        }

        if ($extra) {
            $form['extra'] = json_encode($extra, JSON_UNESCAPED_UNICODE);
        }

        return $form;
    }

    protected function validate($form) {
        $errors = parent::validate($form);
        $module = $this->module();
        $table = $this->table();

        foreach ($module['fields'] as $field) {
            $name = $field['name'];

            if (isset($table->{$name})) {
                $field['multilingual'] = $table->{$name}->multilingual();
            }

            if (@$field['multilingual']) {
                foreach (LANGUAGES as $language) {
                    $errors = $this->validateField($errors, $field, $form, $name, $language);
                }
            } else {
                $errors = $this->validateField($errors, $field, $form, $name, null);
            }
        }

        return $errors;
    }

    protected function wrap() {
        $form = parent::wrap();
        $moduleName = @$form['module'];
        $table = $this->table();

        if ($moduleName) {
            $module = Config::load("module/{$moduleName}");
        } else {
            $block = $table->parent()->model()->get($form['block_id']);
            $moduleName = Config::load("module/{$block['module']}")['sub-module'];
            $module = Config::load("sub-module/{$moduleName}");
        }

        foreach ($module['fields'] as $field) {
            $name = $field['name'];

            if (isset($table->{$name})) {
                continue;
            }

            if (@$field['multilingual']) {
                foreach (LANGUAGES as $language) {
                    $form = $this->wrapField($field, $form, $name, $language);
                }
            } else {
                $form = $this->wrapField($field, $form, $name, null);
            }
        }

        $this->module($module);

        return $form;
    }

    private function packField($extra, $form, $name, $language) {
        if ($language) {
            $name = "{$name}__{$language}";
        }

        $value = @$form[$name];

        if ($value instanceof Attachment) {
            $value->save();
            $value = strval($value);
        }

        if ($value !== null) {
            $extra[$name] = $value;
        }

        return $extra;
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
                $options->pattern(cfg("system.{$field['type']}"));
                break;
            case 'file':
                $options->mimeType(@$field['mimeType']);
                break;
            case 'image':
                $options->mimeType('image\/[\w]+');
                break;
            case 'double':
            case 'email':
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

    private function wrapField($field, $form, $name, $language) {
        if ($language) {
            $name = "{$name}__{$language}";
        }

        switch ($field['type']) {
        case 'file':
        case 'image':
            return Attachment::wrap($form, $name);
        }

        return $form;
    }

}
