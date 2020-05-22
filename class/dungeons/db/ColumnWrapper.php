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
        $this->values = $column->values;
    }

    public function alias() {
        return $this->alias;
    }

    public function convert($value) {
        return $this->column->convert($value);
    }

    public function expression($prefix = null) {
        if ($this->relation['column']->multiple() && $this->relation['type'] === 'association') {
            $title = $this->mapping();
            $foreign = $this->relation['foreign']->mapping();
            $id = $this->relation['target']->mapping();
            $column = $this->relation['column']->expression();
            $ranking = $this->relation['foreign']->ranking() ?? $this->relation['foreign']->id();

            $expression = "SELECT {$title} FROM {$foreign} WHERE {$id}::TEXT = ANY(STRING_TO_ARRAY({$column}, ',')) ORDER BY {$ranking}";

            return "(SELECT STRING_AGG(M.{$title}, ',') FROM ({$expression}) AS M)";
        }

        $default = $this->default();
        $expression = $this->column->expression($prefix ?? $this->alias);

        if ($default !== null) {
            $default = var_export($default, true);

            return "COALESCE({$expression}, {$default})";
        }

        return $expression;
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
