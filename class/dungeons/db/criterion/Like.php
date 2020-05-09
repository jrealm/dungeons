<?php //>

namespace dungeons\db\criterion;

class Like extends AbstractCriterion {

    public function make() {
        return "{$this->column->expression()} LIKE ?";
    }

}
