<?php //>

return new class() extends dungeons\web\backend\UpdateBundle {

    protected function init() {
        $folder = $this->args()[0];
        $prefix = 'config';

        $this->folder($folder === 'base' ? $prefix : "{$prefix}/{$folder}");

        if ($this->user()['id'] !== 1) {
            $this->allow(preg_split('/\|/', cfg('backend.cfg.bundles')));
        }

        parent::init();
    }

};
