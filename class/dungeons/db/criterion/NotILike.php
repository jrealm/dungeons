<?php //>

namespace dungeons\db\criterion;

class NotILike extends AbstractCriterion {

    public function make() {
        return "LOWER({$this->columnName()}) NOT LIKE ?";
    }

}
