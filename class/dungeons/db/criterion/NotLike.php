<?php //>

namespace dungeons\db\criterion;

class NotLike extends AbstractCriterion {

    public function make() {
        return "{$this->columnName()} NOT LIKE ?";
    }

}
