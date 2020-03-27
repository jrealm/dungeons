<?php //>

namespace dungeons\web\backend;

use dungeons\web\UserAction;

class ListBundle extends UserAction {

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

    protected function process($form) {
        $folder = DUNGEONS . $this->folder();
        $files = is_dir($folder) ? scandir($folder) : [];

        if (defined('APP_HOME')) {
            $home = APP_HOME . $this->folder();

            if (is_dir($home)) {
                $files = array_unique(array_merge($files, scandir($home)));

                sort($files);
            }
        }

        $data = [];
        $labels = $this->labels();

        foreach ($files as $file) {
            $info = pathinfo($file);

            if (@$info['extension'] === 'php') {
                $name = $info['filename'];

                $data[] = [
                    'id' => $name,
                    'name' => $name,
                    'remark' => @$labels[$name],
                ];
            }
        }

        return ['success' => true, 'data' => $data];
    }

}
