<?php //>

namespace dungeons\db\criterion;

class LessThan extends AbstractCriterion {

    public function make() {
        return "{$this->columnName()} < ?";
    }

}
