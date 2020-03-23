<?php //>

namespace dungeons\db\column;

use dungeons\Config;

class Id extends AbstractSequence {

    public function generate($value) {
        if (is_null($value)) {
            return $this->nextSequence();
        }

        return $value;
    }

}
