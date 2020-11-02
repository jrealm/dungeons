<?php //>

// php index.php /console/reset-sequence

use dungeons\db\Connection;
use dungeons\db\column\FormNumber;

return new class() extends dungeons\cli\Controller {

    protected function process($form) {
        $files = [];

        foreach (RESOURCE_FOLDERS as $folder) {
            $path = $folder . 'table';

            if (is_dir($path)) {
                $files = array_merge($files, scandir($path));
            }
        }

        $files = array_unique($files);

        sort($files);

        //--

        foreach ($files as $file) {
            $info = pathinfo($file);

            if (@$info['extension'] === 'php') {
                $table = table($info['filename']);

                foreach ($table->getColumns() as $column) {
                    if ($column instanceof FormNumber) {
                        $this->reset($column->sequence());
                    }
                }
            }
        }

        //--

        return ['success' => true];
    }

    private function reset($name) {
        $command = "ALTER SEQUENCE {$name} RESTART";

        $statement = Connection::getInstance()->prepare($command);
        $statement->execute();
    }

};
