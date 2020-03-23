<?php //>

return new class() extends dungeons\web\backend\BlankAction {

    protected function init() {
        $this->table(table('User'));
    }

};
