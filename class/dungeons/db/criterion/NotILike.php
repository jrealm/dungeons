<?php //>

namespace dungeons\db\criterion;

class NotILike extends AbstractCriterion {

    public function make() {
        return "LOWER({$this->column->expression()}) NOT LIKE ?";
    }

}
