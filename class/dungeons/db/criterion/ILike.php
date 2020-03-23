<?php //>

namespace dungeons\db\criterion;

class ILike extends AbstractCriterion {

    public function make() {
        return "LOWER({$this->columnName()}) LIKE ?";
    }

}
