<?php //>

namespace dungeons\db\criterion;

class LessThanOrEqual extends AbstractCriterion {

    public function make() {
        return "{$this->columnName()} <= ?";
    }

}
