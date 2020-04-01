<?php //>

return new class() extends dungeons\web\backend\InsertController {

    protected function init() {
        $this->table(table('Page'));
    }

};
