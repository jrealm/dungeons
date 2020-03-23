<?php //>

return new class() extends dungeons\web\backend\GetAction {

    protected function init() {
        $this->table(table('Group'));
    }

};
