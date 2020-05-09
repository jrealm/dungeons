<?php //>

namespace dungeons\db\criterion;

class NotBetween extends AbstractCriterion {

    public function make() {
        return "{$this->column->expression()} NOT BETWEEN ? AND ?";
    }

}
