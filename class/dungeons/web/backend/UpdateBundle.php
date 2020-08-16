<?php //>

namespace dungeons\web\backend;

use dungeons\Attachment;
use dungeons\db\column\File;
use dungeons\db\Connection;
use dungeons\Resource;
use dungeons\web\BackendController;

class UpdateBundle extends BackendController {

    public function __construct() {
        parent::__construct();

        $this->validationView('backend/validation.php');
        $this->view('backend/update-bundle-success.php');
    }

    public function available() {
        if ($this->method() === 'POST') {
            $info = pathinfo($this->name());
            $pattern = preg_quote($info['dirname'], '/');

            return preg_match("/^{$pattern}\/[\w]+\/{$info['basename']}\/[\w-]+$/", $this->path());
        }

        return false;
    }

    protected function getMenuName() {
        return preg_replace('/^\/backend\/(.+)\/[\w-]+$/', '$1', $this->path());
    }

    protected function init() {
        list($folder, $name) = $this->args();

        $columns = [];
        $file = "{$this->folder()}/{$name}";
        $data = Resource::union("{$file}.php");
        $prefix = "{$this->category()}/{$folder}.{$name}";

        foreach ($data as $name => $ignore) {
            $class = cfg("style/{$prefix}.{$name}");

            if ($class) {
                $columns[$name] = new $class();
            }
        }

        $this->columns($columns);
        $this->data($data);
        $this->file($file);
    }

    protected function process($form) {
        $node = dirname($this->getMenuName());

        if ($this->user()['id'] === 1) {
            $allow = null;
        } else {
            $allow = preg_split('/\|/', cfg("backend.{$node}"));
        }

        $name = $this->args()[1];

        if ($allow === null || in_array($name, $allow)) {
            $data = $this->data();
        } else {
            $data = null;
        }

        if (!$data) {
            return ['error' => 'error.DataNotFound'];
        }

        if (!defined('APP_DATA')) {
            return ['error' => 'error.UpdateFailed'];
        }

        $path = defined('CUSTOM_APP') ? (APP_DATA . CUSTOM_APP . '/') : APP_DATA;

        if (create_folder($path . $this->folder()) === false) {
            return ['error' => 'error.UpdateFailed'];
        }

        $file = $path . $this->file();

        if (file_exists($file)) {
            if (!is_file($file) || !is_writable($file)) {
                return ['error' => 'error.UpdateFailed'];
            }
        }

        $diff = [];

        foreach ($data as $name => $value) {
            $new = @$form[$name];

            if ($new === null) {
                continue;
            }

            if ($new instanceof Attachment) {
                $new->save();

                $diff[$name] = strval($new);
            } else if ($new !== $value) {
                $diff[$name] = $new;
            }
        }

        if (file_exists($file)) {
            $info = pathinfo($file);
            $id = Connection::getInstance()->nextSequence('base_ranking');
            $backup = $info['dirname'] . '/.' . $info['basename'] . '.' . $id . '.' . $this->user()['id'];

            rename($file, $backup);
        }

        if ($diff) {
            file_put_contents($file, json_encode($diff, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }

        return ['success' => true];
    }

    protected function validate($form) {
        $errors = [];

        foreach ($this->columns() as $name => $column) {
            $value = @$form[$name];

            if ($value === null) {
                if ($column->required()) {
                    $errors[] = ['name' => $name, 'type' => 'required'];
                }
            } else {
                $type = validate($value, $column);

                if ($type) {
                    $errors[] = ['name' => $name, 'type' => $type];
                }
            }
        }

        return $errors;
    }

    protected function wrap() {
        $form = parent::wrap();

        foreach ($this->columns() as $name => $column) {
            if ($column instanceof File) {
                $form = Attachment::wrap($form, $name);
            }
        }

        return $form;
    }

}
