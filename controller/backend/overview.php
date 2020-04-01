<?php //>

return new class() extends dungeons\web\UserAction {

    public function __construct() {
        parent::__construct();

        $this->view('backend/overview.twig');
    }

};
