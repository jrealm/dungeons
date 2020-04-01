<?php //>

return new class() extends dungeons\web\backend\UpdateController {

    protected function init() {
        $table = table('User');
        $table->password->required(false);

        $this->table($table);
    }

};
