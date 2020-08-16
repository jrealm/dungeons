<?php //>

return new class() extends dungeons\web\backend\UpdateBundle {

    protected function init() {
        $folder = $this->args()[0];
        $prefix = 'config';

        $this->category('config');
        $this->folder($folder === 'base' ? $prefix : "{$prefix}/{$folder}");

        parent::init();
    }

};
