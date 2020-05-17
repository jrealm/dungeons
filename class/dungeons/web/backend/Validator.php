<?php //>

namespace dungeons\web\backend;

use dungeons\db\Column;
use ReflectionMethod;

trait Validator {

    protected function validate($form) {
        $errors = [];

        foreach ($this->columns() ?? $this->table()->getColumns() as $name => $column) {
            $value = @$form[$name];

            if ($value === null) {
                if ($column->required()) {
                    $method = new ReflectionMethod(get_class($column), $this->generator());

                    if ($method->getDeclaringClass()->getName() === Column::class) {
                        $errors[] = ['name' => $name, 'type' => 'required'];
                    }
                }
            } else {
                $type = validate($value, $column);

                if ($type) {
                    $errors[] = ['name' => $name, 'type' => $type];
                } else if ($column->unique()) {
                    $id = @$form['id'];
                    $condition = [$column->equal($value)];

                    if ($id !== null) {
                        $condition[] = $this->table()->id->notEqual($id);
                    }

                    if ($this->table()->model()->count($condition)) {
                        $errors[] = ['name' => $name, 'type' => 'duplicated'];
                    }
                } else {
                    $alias = $column->association();

                    if ($alias) {
                        $relation = $this->table()->getRelations()[$alias];

                        if (empty($relation['enable'])) {
                            $foreign = table($relation['foreign']);
                            $target = $foreign->{$relation['target']};
                        } else {
                            $foreign = $relation['foreign'];
                            $target = $relation['target'];
                        }

                        if (!$foreign->model()->count([$target->equal($value)])) {
                            $errors[] = ['name' => $name, 'type' => 'not-found'];
                        }
                    }
                }
            }
        }

        return $errors;
    }

}
