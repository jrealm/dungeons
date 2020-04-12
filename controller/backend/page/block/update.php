<?php //>

use dungeons\Config;

return new class() extends dungeons\web\backend\UpdateController {

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

                if (empty($table->$name)) {
                    $extra[$name] = @$form[$name];
                }
            }

            if ($extra) {
                $form['extra'] = json_encode($extra);
            }
        }

        return $form;
    }

};
