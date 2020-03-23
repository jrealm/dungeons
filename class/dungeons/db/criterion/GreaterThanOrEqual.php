<?php //>

namespace dungeons\db\criterion;

class GreaterThanOrEqual extends AbstractCriterion {

    public function make() {
        return "{$this->columnName()} >= ?";
    }

}
