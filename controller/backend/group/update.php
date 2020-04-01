<?php //>

return new class() extends dungeons\web\backend\UpdateController {

    protected function init() {
        $this->table(table('Group'));
    }

};
