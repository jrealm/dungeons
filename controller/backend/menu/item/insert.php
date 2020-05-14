<?php //>

return new class() extends dungeons\web\backend\InsertController {

    use dungeons\web\backend\SubCreation;

    protected function init() {
        $this->table(table('SubMenu'));
    }

};
