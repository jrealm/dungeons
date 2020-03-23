<?php //>

namespace dungeons\db\criterion;

class IsNull extends AbstractCriterion {

    public function make() {
        return "{$this->columnName()} IS NULL";
    }

}
