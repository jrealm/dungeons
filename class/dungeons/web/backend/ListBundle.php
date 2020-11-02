<?php //>

namespace dungeons\web\backend;

use dungeons\web\BackendController;

class ListBundle extends BackendController {

    public function __construct() {
        parent::__construct();

        $this->view('backend/list-bundle.php');
    }

    public function available() {
        if ($this->method() === 'POST') {
            $pattern = preg_quote($this->name(), '/');

            return preg_match("/^{$pattern}\/([\w]+)$/", $this->path());
        }

        return false;
    }

    protected function getMenuName() {
        return preg_replace('/^\/backend\/(.+)$/', '$1', $this->path());
    }

    protected function process($form) {
        $files = [];

        foreach (RESOURCE_FOLDERS as $folder) {
            $path = $folder . $this->folder();

            if (is_dir($path)) {
                $files = array_merge($files, scandir($path));
            }
        }

        $files = array_unique($files);

        sort($files);

        $node = $this->getMenuName();

        if ($this->user()['id'] === 1) {
            $allow = null;
        } else {
            $allow = preg_split('/\|/', cfg("backend.{$node}"));
        }

        $data = [];

        foreach ($files as $file) {
            $info = pathinfo($file);

            if (@$info['extension'] === 'php') {
                $name = $info['filename'];

                if ($allow === null || in_array($name, $allow)) {
                    $data[] = [
                        'id' => $name,
                        'name' => $name,
                        'remark' => i18n("{$node}.{$name}", ''),
                    ];
                }
            }
        }

        return ['success' => true, 'data' => $data];
    }

}
