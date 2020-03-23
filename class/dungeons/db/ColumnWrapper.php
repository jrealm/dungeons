<?php //>

namespace dungeons\db;

class ColumnWrapper extends Column {

    private $column;
    private $prefix;

    public function __construct($prefix, $column) {
        $this->prefix = $prefix;
        $this->column = $column;
        $this->values = &$column->values;
    }

    public function convert($value) {
        return $this->column->convert($value);
    }

    public function generate($value) {
        return $this->column->generate($value);
    }

    public function prefix() {
        return $this->prefix;
    }

    public function regenerate($value) {
        return $this->column->regenerate($value);
    }

    public function type() {
        return $this->column->type();
    }

    public function validate($value) {
        return $this->column->validate($value);
    }

}
