<?php //>

namespace dungeons\db\column;

class Serial extends Integer {

    use Sequence;

    public function generate($value) {
        if ($value === null) {
            return $this->nextSequence();
        }

        return $value;
    }

}
