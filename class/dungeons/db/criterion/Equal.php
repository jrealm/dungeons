<?php //>

namespace dungeons\db\criterion;

class Equal extends AbstractCriterion {

    protected function build($expression) {
        return "{$expression} = ?";
    }

}
