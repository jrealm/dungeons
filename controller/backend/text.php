<?php //>

return new class() extends dungeons\web\BackendController {

    protected function init() {
        $this->view('backend/text.twig');
    }

    protected function process($form) {
        return ['success' => true, 'content' => i18n($form['name'], '')];
    }

};
