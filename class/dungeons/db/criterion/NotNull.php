<?php //>

namespace dungeons\db\criterion;

class NotNull extends AbstractCriterion {

    public function make() {
        return "{$this->columnName()} IS NOT NULL";
    }

}
