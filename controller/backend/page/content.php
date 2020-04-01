<?php //>

return new class() extends dungeons\web\backend\GetController {

    protected function init() {
        $this->table(table('Page'));
    }

};
