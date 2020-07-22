<?php //>

namespace dungeons\db\criterion;

class NotEqual extends AbstractCriterion {

    protected function build($expression) {
        return "{$expression} <> ?";
    }

}
