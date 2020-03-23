<?php //>

return new class() extends dungeons\web\backend\DeleteAction {

    protected function init() {
        $this->table(table('Group'));
    }

};
