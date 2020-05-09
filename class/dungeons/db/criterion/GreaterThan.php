<?php //>

namespace dungeons\db\criterion;

class GreaterThan extends AbstractCriterion {

    public function make() {
        return "{$this->column->expression()} > ?";
    }

}
