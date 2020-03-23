<?php //>

return new class() extends dungeons\web\backend\UpdateAction {

    protected function init() {
        $this->table(table('Group'));
    }

};
