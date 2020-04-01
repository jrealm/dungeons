<?php //>

return new class() extends dungeons\web\backend\InsertAction {

    protected function init() {
        $this->table(table('Page'));
    }

};
