<?php //>

return new class() extends dungeons\web\Controller {

    public function available() {
        return true;
    }

    protected function process($form) {
        return ['view' => '404.php'];
    }

};
