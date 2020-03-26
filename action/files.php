<?php //>

return new class() extends dungeons\web\Action {

    public function available() {
        return true;
    }

    protected function process($form) {
        return ['success' => true, 'view' => '404.php'];
    }

};
