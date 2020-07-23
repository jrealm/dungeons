<?php //>

return new class() extends dungeons\cli\Controller {

    public function execute() {
        resolve('console/init-db.twig')->render($this, [], [
            'db_name' => substr(strstr(DB_NAME, '='), 1),
            'db_user' => DB_USER,
        ]);
    }

};
