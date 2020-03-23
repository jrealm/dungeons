<?php //>

namespace dungeons\db\criterion;

class Between extends AbstractCriterion {

    public function make() {
        return "{$this->columnName()} BETWEEN ? AND ?";
    }

}
