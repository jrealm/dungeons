<?php //>

// php index.php /console/init-model custom_article [-model=Article] [-node=article]

use dungeons\db\Connection;

return new class() extends dungeons\cli\Controller {

    protected function process($form) {
        $table = @$form[0];

        if ($table === null) {
            return ['message' => 'invalid arguments'];
        }

        //--

        $model = $this->model();

        if ($model === null) {
            $tokens = explode('_', $table);
            $model = implode(array_map('ucfirst', array_splice($tokens, 1)));
        }

        //--

        $path = $this->node();

        if ($path === null) {
            $path = strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', $model));
        }

        //--

        $metadata = $this->getDefinition($table);

        if (!$metadata) {
            return ['message' => 'table not found'];
        }

        $types = [];

        foreach ($metadata as $data) {
            $types[$data['data_type']] = ucfirst(strtok($data['data_type'], ' '));
        }

        ksort($types);

        //-- model

        ob_start();

        resolve('console/template/model.twig')->render($this, [], [
            'table' => $table,
            'metadata' => $metadata,
            'types' => $types,
        ]);

        $this->save(APP_HOME . "table/{$model}.php", ob_get_clean());

        //-- message

        foreach (LANGUAGES as $lang) {
            ob_start();

            resolve('console/template/message.twig')->render($this, [], ['metadata' => $metadata, 'language' => $lang]);

            @mkdir(APP_HOME . "message/{$lang}/table", 0777, true);

            $this->save(APP_HOME . "message/{$lang}/table/{$model}.php", ob_get_clean());
        }

        //-- list controller

        @mkdir(APP_HOME . "controller/backend/{$path}", 0777, true);

        ob_start();

        resolve('console/template/list.twig')->render($this, [], [
            'model' => $model,
            'metadata' => $metadata,
        ]);

        $this->save(APP_HOME . "controller/backend/{$path}.php", ob_get_clean());

        //-- other controllers

        foreach (['content', 'delete', 'insert', 'new', 'update'] as $action) {
            ob_start();

            resolve("console/template/{$action}.twig")->render($this, [], ['model' => $model]);

            $this->save(APP_HOME . "controller/backend/{$path}/{$action}.php", ob_get_clean());
        }

        //-- permission

        ob_start();

        resolve('console/template/permission.twig')->render($this, [], [
            'model' => $model,
            'path' => $path,
            'metadata' => $metadata,
        ]);

        echo ob_get_clean();

        //--

        return ['success' => true];
    }

    private function getDefinition($table) {
        $command = "SELECT column_name, data_type, is_nullable
                      FROM information_schema.columns
                     WHERE table_catalog = CURRENT_DATABASE()
                       AND table_name = '{$table}'
                       AND column_name <> 'id'
                       AND column_name NOT LIKE '%\\_\\_%'";

        $statement = Connection::getInstance()->prepare($command);
        $statement->execute();

        $metadata = [];

        foreach ($statement->fetchAll() as $row) {
            $name = $row['column_name'];

            unset($row['column_name']);

            $row['is_nullable'] = ($row['is_nullable'] === 'YES');

            switch ($name) {
            case 'create_time':
                $row['data_type'] = 'createTime';
                break;
            case 'creator':
                $row['data_type'] = 'creator';
                break;
            case 'disable_time':
                $row['data_type'] = 'disableTime';
                break;
            case 'enable_time':
                $row['data_type'] = 'enableTime';
                break;
            case 'image':
                $row['data_type'] = 'image';
                break;
            case 'mail':
                $row['data_type'] = 'email';
                break;
            case 'password':
                $row['data_type'] = 'password';
                break;
            }

            $metadata[$name] = $row;
        }

        return $metadata;
    }

    private function save($file, $content) {
        if (file_exists($file) || !@file_put_contents($file, $content)) {
            echo "------------------------------------------------------------\n";
            echo $file . "\n";
            echo "============================================================\n";
            echo $content . "\n";
            echo "============================================================\n";
        }
    }

};
