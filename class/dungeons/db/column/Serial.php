<?php //>

namespace dungeons\db\column;

class Serial extends Integer {

    use Sequence;

    public function generate($value) {
        if (is_null($value)) {
            return $this->nextSequence();
        }

        return $value;
    }

}
