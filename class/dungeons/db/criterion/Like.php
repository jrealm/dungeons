<?php //>

namespace dungeons\db\criterion;

class Like extends AbstractCriterion {

    protected function build($expression) {
        return "{$expression} LIKE ?";
    }

}
