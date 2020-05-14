<?php //>

return new class() extends dungeons\web\backend\BlankController {

    use dungeons\web\backend\SubCreation;

    protected function init() {
        $this->table(table('SubMenu'));
    }

};
