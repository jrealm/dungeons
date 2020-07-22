<?php //>

namespace dungeons\db\criterion;

class IsNull extends AbstractCriterion {

    protected function build($expression) {
        return "{$expression} IS NULL";
    }

}
