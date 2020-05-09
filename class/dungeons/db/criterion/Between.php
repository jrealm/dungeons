<?php //>

namespace dungeons\db\criterion;

class Between extends AbstractCriterion {

    public function make() {
        return "{$this->column->expression()} BETWEEN ? AND ?";
    }

}
