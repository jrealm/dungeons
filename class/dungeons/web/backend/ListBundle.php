<?php //>

namespace dungeons\web\backend;

use dungeons\web\UserAction;

class ListBundle extends UserAction {

    public function __construct() {
        parent::__construct();

        $this->view('backend/list-bundle.php');
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
