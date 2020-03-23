<?php //>

namespace dungeons\db\column;

use dungeons\Config;

class Ranking extends AbstractSequence {

    public function generate($value) {
        if (is_null($value)) {
            return $this->nextSequence();
        }

        return $value;
    }

    public function regenerate($value) {
        return $this->generate($value);
    }

}
