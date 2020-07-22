<?php //>

namespace dungeons\db\criterion;

class LessThanOrEqual extends AbstractCriterion {

    protected function build($expression) {
        return "{$expression} <= ?";
    }

}
