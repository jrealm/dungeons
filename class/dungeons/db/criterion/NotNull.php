<?php //>

namespace dungeons\db\criterion;

class NotNull extends AbstractCriterion {

    public function make() {
        return "{$this->column->expression()} IS NOT NULL";
    }

}
