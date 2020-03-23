<?php //>

namespace dungeons\db\criterion;

class NotBetween extends AbstractCriterion {

    public function make() {
        return "{$this->columnName()} NOT BETWEEN ? AND ?";
    }

}
