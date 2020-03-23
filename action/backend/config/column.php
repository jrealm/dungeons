<?php //>

use dungeons\Message;

return new class() extends dungeons\web\backend\ListBundle {

    public function __construct() {
        parent::__construct();

        $this->folder('config/column');
        $this->labels(Message::load('config-column'));
    }

};
