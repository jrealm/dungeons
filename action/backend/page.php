<?php //>

return new class() extends dungeons\web\backend\ListAction {

    protected function init() {
        $this->table(table('Page'));
    }

};
