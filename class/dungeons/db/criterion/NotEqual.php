<?php //>

namespace dungeons\db\criterion;

class NotEqual extends AbstractCriterion {

    public function make() {
        return "{$this->columnName()} <> ?";
    }

}
