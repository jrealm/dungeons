<?php //>

namespace dungeons\db\column;

use dungeons\db\Connection;

class AbstractSequence extends Integer {

    protected function nextSequence() {
        return Connection::getInstance()->nextSequence($this->sequence());
    }

}
