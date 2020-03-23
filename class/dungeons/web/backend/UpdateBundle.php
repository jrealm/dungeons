<?php //>

namespace dungeons\web\backend;

use dungeons\Resource;
use dungeons\web\UserAction;

class UpdateBundle extends UserAction {

    public function __construct() {
        parent::__construct();

        $this->view('backend/update-success.php');
    }

    public function available() {
        if ($this->method() === 'POST') {
            return preg_match("#^{$this->name()}/[^/]+$#", $this->path());
        }

        return false;
    }

    protected function init() {
        $file = "{$this->folder()}/{$this->args()[0]}";
        $data = Resource::union("{$file}.php");

        $this->file($file);
        $this->data($data);

        if ($data) {
            $this->styles($data['@'] ?? []);
        }
    }

    protected function process($form) {
        $data = $this->data();

        if (!$data) {
            return ['error' => 'error.DataNotFound'];
        }

        if (!defined('APP_DATA') || create_folder(APP_DATA . $this->folder()) === false) {
            return ['error' => 'error.UpdateFailed'];
        }

        $file = APP_DATA . $this->file();

        if (file_exists($file)) {
            if (!is_file($file) || !is_writable($file)) {
                return ['error' => 'error.UpdateFailed'];
            }
        }

        $diff = [];

        foreach ($data as $name => $value) {
            $new = @$form[$name];

            if (!is_null($new) && $new !== $value) {
                $diff[$name] = $new;
            }
        }

        if ($diff) {
            file_put_contents($file, json_encode($diff, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        } else if (file_exists($file)) {
            unlink($file);
        }

        return ['success' => true];
    }

    protected function wrap() {
        $form = parent::wrap();
        $styles = $this->styles();

        if ($styles && defined('APP_FILES')) {
            foreach ($styles as $name => $style) {
                if ($style['type'] === 'image') {
                    $value = @$form[$name];

                    if ($value && preg_match('/^data:/', $value)) {
                        $folder = create_folder(APP_FILES . date('Ymd/'));

                        if ($folder) {
                            $file = tempnam($folder, '');
                            $value = substr($value, strpos($value, ','));

                            if (file_put_contents($file, base64_decode($value)) !== false) {
                                $form[$name] = substr($file, strlen(APP_FILES));
                            }
                        }
                    }
                }
            }
        }

        return $form;
    }

}
