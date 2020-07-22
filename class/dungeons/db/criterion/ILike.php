<?php //>

namespace dungeons\db\criterion;

class ILike extends AbstractCriterion {

    protected function build($expression) {
        return "LOWER({$expression}) LIKE ?";
    }

}
