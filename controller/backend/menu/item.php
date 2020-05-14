<?php //>

return new class() extends dungeons\web\backend\ListController {

    use dungeons\web\backend\SubList;

    protected function init() {
        $this->table(table('SubMenu'));
    }

};
