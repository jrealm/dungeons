<?php //>

use dungeons\Config;

return new class() extends dungeons\web\backend\InsertController {

    public function available() {
        if ($this->method() === 'POST') {
            return preg_match("/^\/backend\/page\/[\d]+\/blocks\/insert$/", $this->path());
        }

        return false;
    }

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
