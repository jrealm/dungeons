<?php //>

namespace dungeons\db\criterion;

class GreaterThan extends AbstractCriterion {

    protected function build($expression) {
        return "{$expression} > ?";
    }

}
