<?php //>

return new class() extends dungeons\web\UserController {

    protected function process($form) {
        if (!defined('APP_DATA') || create_folder(APP_DATA . 'setting') === false) {
            return ['error' => 'error.UpdateFailed'];
        }

        $file = APP_DATA . 'setting/' . $this->user()['id'];

        if (file_exists($file)) {
            if (!is_file($file) || !is_writable($file)) {
                return ['error' => 'error.UpdateFailed'];
            }

            $setting = json_decode(file_get_contents($file), true);
        } else {
            $setting = [];
        }

        $size = intval(@$form['s']);

        if (in_array($size, [20, 30, 50, 100])) {
            $setting['pageSize'] = $size;
        } else {
            unset($setting['pageSize']);
        }

        if ($setting) {
            file_put_contents($file, json_encode($setting, JSON_PRETTY_PRINT));
        } else if (file_exists($file)) {
            unlink($file);
        }

        return ['success' => true, 'type' => 'refresh'];
    }

};
