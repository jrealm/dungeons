<?php //>

namespace dungeons\db\criterion;

class Equal extends AbstractCriterion {

    public function make() {
        return "{$this->columnName()} = ?";
    }

}
