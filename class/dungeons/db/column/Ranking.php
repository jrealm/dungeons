<?php //>

namespace dungeons\db\column;

class Ranking extends AbstractSequence {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->table()->ranking($this->name());
    }

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
