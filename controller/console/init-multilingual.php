<?php //>

// php index.php /console/init-multilingual

use dungeons\db\Connection;

return new class() extends dungeons\cli\Controller {

    private $db;

    public function __construct() {
        parent::__construct();

        $this->db = Connection::getInstance();
    }

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
                    if ($column->multilingual()) {
                        foreach (LANGUAGES as $language) {
                            $this->add($table->mapping(), $column->mapping(), $language);
                        }
                    }
                }

                if ($table->versionable() && !$this->defined($table->mapping(), '__version__')) {
                    $command = "ALTER TABLE {$table->mapping()} ADD COLUMN __version__ INTEGER";

                    echo "{$command};\n";

                    $statement = $this->db->prepare($command);
                    $statement->execute();

                    //--

                    $command = "UPDATE {$table->mapping()} SET __version__ = 1";

                    echo "{$command};\n";

                    $statement = $this->db->prepare($command);
                    $statement->execute();

                }
            }
        }

        //--

        return ['success' => true];
    }

    private function add($table, $column, $language) {
        if ($this->defined($table, $column, $language)) {
            return;
        }

        $type = $this->type($table, $column);

        //--

        $command = "ALTER TABLE {$table} ADD COLUMN {$column}__{$language} {$type}";

        echo "{$command};\n";

        $statement = $this->db->prepare($command);
        $statement->execute();

        //--

        $command = "UPDATE {$table} SET {$column}__{$language} = {$column}";

        echo "{$command};\n";

        $statement = $this->db->prepare($command);
        $statement->execute();
    }

    private function defined($table, $column, $language = null) {
        if ($language) {
            $column = "{$column}__{$language}";
        }

        $command = "
            SELECT COUNT(*) as \"count\"
              FROM information_schema.columns
             WHERE table_catalog = CURRENT_DATABASE()
               AND table_name = '{$table}'
               AND column_name = '{$column}'
        ";

        $statement = $this->db->prepare($command);
        $statement->execute();

        return intval($statement->fetch()['count']);
    }

    private function type($table, $column) {
        $command = "
            SELECT data_type
              FROM information_schema.columns
             WHERE table_catalog = CURRENT_DATABASE()
               AND table_name = '{$table}'
               AND column_name = '{$column}'
        ";

        $statement = $this->db->prepare($command);
        $statement->execute();

        return strtoupper($statement->fetch()['data_type']);
    }

};
