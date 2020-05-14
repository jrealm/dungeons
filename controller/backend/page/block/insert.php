<?php //>

use dungeons\Config;

return new class() extends dungeons\web\backend\InsertController {

    use dungeons\web\backend\SubCreation;

    protected function init() {
        $this->table(table('Block'));
    }

    protected function preprocess($form) {
        $module = Config::load("module/{$form['module']}");

        if ($module) {
            $extra = [];
            $table = $this->table();

            foreach ($module['fields'] as $field) {
                $name = $field['name'];
                $value = @$field['default'];

                if (empty($table->$name)) {
                    $extra[$name] = $value;
                } else {
                    $form[$name] = $value;
                }
            }

            if ($extra) {
                $form['extra'] = json_encode($extra);
            }
        }

        return $form;
    }

};
