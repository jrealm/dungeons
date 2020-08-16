<?php //>

return new class() extends dungeons\web\backend\ListBundle {

    protected function init() {
        $folder = $this->args()[0];

        if ($folder === 'base') {
            $this->folder('message/' . constant('LANGUAGE'));
        } else {
            $this->folder('message/' . constant('LANGUAGE') . '/' . $folder);
        }
    }

};
