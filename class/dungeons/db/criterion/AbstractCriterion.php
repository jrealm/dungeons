<?php //>

namespace dungeons\db\criterion;

use dungeons\db\Criterion;

abstract class AbstractCriterion implements Criterion {

    protected $column;
    protected $values;

    public function __construct($column, $values) {
        $this->column = $column;
        $this->values = array_map([$column, 'convert'], $values);
    }

    public function bind($statement, $bindings) {
        $type = $this->column->type();

        foreach ($this->values as $value) {
            $bindings[] = $value;

            $statement->bindValue(count($bindings), $value, $type);
        }

        return $bindings;
    }

    protected function columnName() {
        return "_{$this->column->prefix()}.{$this->column->mapping()}";
    }

}
