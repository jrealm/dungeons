<?php //>

return new class() extends dungeons\web\backend\UpdateBundle {

    protected function init() {
        $folder = $this->args()[0];
        $prefix = 'message/' . constant('LANGUAGE');

        $this->folder($folder === 'base' ? $prefix : "{$prefix}/{$folder}");

        if ($this->user()['id'] !== 1) {
            if ($folder === 'base') {
                $bundles = 'backend.i18n.bundles';
            } else {
                $bundles = "backend.i18n.{$folder}.bundles";
            }

            $this->allow(preg_split('/\|/', cfg($bundles)));
        }

        parent::init();
    }

};
