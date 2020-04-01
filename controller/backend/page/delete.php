<?php //>

return new class() extends dungeons\web\backend\DeleteController {

    protected function init() {
        $this->table(table('Page'));
    }

};
