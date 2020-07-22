<?php //>

namespace dungeons\db\criterion;

class Between extends AbstractCriterion {

    protected function build($expression) {
        return "{$expression} BETWEEN ? AND ?";
    }

}
