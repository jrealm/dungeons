<?php //>

namespace dungeons\db\criterion;

class LessThan extends AbstractCriterion {

    protected function build($expression) {
        return "{$expression} < ?";
    }

}
