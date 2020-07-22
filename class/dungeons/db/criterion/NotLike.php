<?php //>

namespace dungeons\db\criterion;

class NotLike extends AbstractCriterion {

    protected function build($expression) {
        return "{$expression} NOT LIKE ?";
    }

}
