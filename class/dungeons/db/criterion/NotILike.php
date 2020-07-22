<?php //>

namespace dungeons\db\criterion;

class NotILike extends AbstractCriterion {

    protected function build($expression) {
        return "LOWER({$expression}) NOT LIKE ?";
    }

}
