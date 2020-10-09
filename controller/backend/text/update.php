<?php //>

use dungeons\db\Connection;
use dungeons\Resource;

return new class() extends dungeons\web\BackendController {

    protected function init() {
        $this->view('backend/update-text-success.twig');
    }

    protected function process($form) {
        list($name, $key) = preg_split('/\./', $form['name'], 2);

        $path = 'message/' . constant('LANGUAGE') . '/' . $name;
        $bundle = Resource::union("{$path}.php");

        $file = Resource::getDataFile($path, false);

        if (file_exists($file)) {
            if (!is_file($file) || !is_writable($file)) {
                return ['error' => 'error.UpdateFailed'];
            }

            $data = json_decode(file_get_contents($file), true);
        } else {
            $data = [];
        }

        if ($form['content'] === null || $form['content'] === @$bundle[$key]) {
            unset($data[$key]);
        } else {
            $data[$key] = $form['content'];
        }

        if (file_exists($file)) {
            $info = pathinfo($file);
            $id = Connection::getInstance()->nextSequence('base_ranking');
            $backup = $info['dirname'] . '/.' . $info['basename'] . '.' . $id . '.' . $this->user()['id'];

            rename($file, $backup);
        }

        if ($data) {
            if (create_folder(dirname($file)) === false) {
                return ['error' => 'error.UpdateFailed'];
            }

            file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }

        //--

        $content = @$data[$key];

        if ($content === null) {
            $content = @$bundle[$key];

            if ($content === null) {
                preg_match('/^(config|message)\/[^.]+\.[^.]+\.(.*)/', $form['name'], $matches);

                $content = $matches ? $matches[2] : "{{$form['name']}}";
            }
        }

        return ['success' => true];
    }

};
