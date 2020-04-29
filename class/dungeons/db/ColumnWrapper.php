<?php //>

namespace dungeons\db;

class ColumnWrapper extends Column {

    private $alias;
    private $column;

    public function __construct($alias, $column) {
        $this->alias = $alias;
        $this->column = $column;
        $this->values = &$column->values;
    }

    public function alias() {
        return $this->alias;
    }

    public function convert($value) {
        return $this->column->convert($value);
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

    public function type() {
        return $this->column->type();
    }

}
