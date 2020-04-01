<?php //>

return new class() extends dungeons\web\backend\BlankController {

    protected function init() {
        $this->table(table('User'));
    }

};
