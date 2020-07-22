<?php //>

namespace dungeons\db\criterion;

class NotBetween extends AbstractCriterion {

    protected function build($expression) {
        return "{$expression} NOT BETWEEN ? AND ?";
    }

}
