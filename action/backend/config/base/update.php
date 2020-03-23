<?php //>

use dungeons\Message;

return new class() extends dungeons\web\backend\UpdateBundle {

    public function __construct() {
        parent::__construct();

        $this->folder('config');
    }

};
