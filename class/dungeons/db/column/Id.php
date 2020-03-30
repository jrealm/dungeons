<?php //>

namespace dungeons\db\column;

class Id extends AbstractSequence {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->table()->id($this);
    }

    public function generate($value) {
        if (is_null($value)) {
            return $this->nextSequence();
        }

        return $value;
    }

}
