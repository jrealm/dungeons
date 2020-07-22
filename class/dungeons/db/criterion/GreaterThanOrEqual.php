<?php //>

namespace dungeons\db\criterion;

class GreaterThanOrEqual extends AbstractCriterion {

    protected function build($expression) {
        return "{$expression} >= ?";
    }

}
