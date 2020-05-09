<?php //>

namespace dungeons\db;

class ColumnWrapper extends Column {

    private $alias;
    private $column;
    private $relation;

    public function __construct($alias, $column, $relation) {
        $this->alias = $alias;
        $this->column = $column;
        $this->relation = $relation;
        $this->values = &$column->values;
    }

    public function alias() {
        return $this->alias;
    }

    public function convert($value) {
        return $this->column->convert($value);
    }

    public function expression($prefix = null) {
        return $this->column->expression($prefix ?? $this->alias);
    }

    public function generate($value) {
        return $this->column->generate($value);
    }

    public function isCounter() {
        return ($this->column instanceof column\Counter);
    }

    public function regenerate($value) {
        return $this->column->regenerate($value);
    }

    public function relation() {
        return $this->relation;
    }

    public function type() {
        return $this->column->type();
    }

}
