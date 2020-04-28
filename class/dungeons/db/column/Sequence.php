<?php //>

namespace dungeons\db\column;

use dungeons\db\Connection;

trait Sequence {

    private function nextSequence() {
        return Connection::getInstance()->nextSequence($this->sequence());
    }

}
