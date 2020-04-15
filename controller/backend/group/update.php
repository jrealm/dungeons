<?php //>

return new class() extends dungeons\web\backend\UpdateController {

    protected function init() {
        $this->table(table('Group'));
    }

    protected function process($form) {
        $result = parent::process($form);

        if (@$result['success']) {
            if (!defined('APP_DATA') || create_folder(APP_DATA . 'permission') === false) {
                return ['error' => 'error.UpdateFailed'];
            }

            $file = APP_DATA . 'permission/' . $result['data']['id'];

            if (file_exists($file)) {
                if (!is_file($file) || !is_writable($file)) {
                    return ['error' => 'error.UpdateFailed'];
                }
            }

            $permissions = [];

            if (@$form['permissions']) {
                foreach ($form['permissions'] as $perm) {
                    if (is_string($perm)) {
                        $path = strtok($perm, ':');
                        $tag = strtok(':');

                        if (key_exists($path, $permissions)) {
                            $permissions[$path][$tag] = 1;
                        } else {
                            $permissions[$path] = [$tag => 1];
                        }
                    }
                }
            }

            if ($permissions) {
                file_put_contents($file, json_encode($permissions, JSON_PRETTY_PRINT));
            } else if (file_exists($file)) {
                unlink($file);
            }
        }

        return $result;
    }

};
