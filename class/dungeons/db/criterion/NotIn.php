<?php //>

namespace dungeons\db\criterion;

class NotIn extends AbstractCriterion {

    protected function build($expression) {
        $count = count($this->values);

        switch ($count) {
        case 0:
            return false;

        case 1:
            return "{$expression} <> ?";

        default:
            $values = implode(',', array_fill(0, $count, '?'));
            return "{$expression} NOT IN ({$values})";
        }
    }

}
