<?php //>

// php index.php /console/reset-sequence

use dungeons\db\Connection;
use dungeons\db\column\FormNumber;

return new class() extends dungeons\cli\Controller {

    protected function process($form) {
        $folder = DUNGEONS . 'table';
        $files = is_dir($folder) ? scandir($folder) : [];

        if (defined('APP_HOME')) {
            $home = APP_HOME . 'table';

            if (is_dir($home)) {
                $files = array_unique(array_merge($files, scandir($home)));

                sort($files);
            }
        }

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
