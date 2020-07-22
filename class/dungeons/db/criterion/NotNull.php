<?php //>

namespace dungeons\db\criterion;

class NotNull extends AbstractCriterion {

    protected function build($expression) {
        return "{$expression} IS NOT NULL";
    }

}
