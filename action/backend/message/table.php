<?php //>

use dungeons\Message;

return new class() extends dungeons\web\backend\ListBundle {

    public function __construct() {
        parent::__construct();

        $this->folder('message/' . constant('LANGUAGE') . '/table');
        $this->labels(Message::load('message-table'));
    }

};
