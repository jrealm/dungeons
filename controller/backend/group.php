<?php //>

return new class() extends dungeons\web\backend\ListController {

    protected function init() {
        $this->table(table('Group'));
    }

};
