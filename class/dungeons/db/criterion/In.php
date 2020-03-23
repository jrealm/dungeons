<?php //>

namespace dungeons\db\criterion;

class In extends AbstractCriterion {

    public function make() {
        $count = count($this->values);

        switch ($count) {
            case 0:
                return '1 <> 1';

            case 1:
                return "{$this->columnName()} = ?";

            default:
                $values = implode(',', array_fill(0, $count, '?'));
                return "{$this->columnName()} IN ({$values})";
        }
    }

}
