<?php //>

namespace dungeons\db;

class Dialect {

    public function makeCountSelection($table, $criteria) {
        $command = "SELECT COUNT(*) AS \"count\" FROM {$table->mapping()} AS _";
        $command = $this->makeRelationJoin($command, $table->getRelations());

        return $this->makeCriteria($command, $criteria);
    }

    public function makeCriteria($command, $criteria) {
        $expression = $criteria->make();

        if ($expression === false) {
            return $command;
        }

        return "{$command} WHERE {$expression}";
    }

    public function makeDeletion($table, $criteria) {
        $command = "DELETE FROM {$table->mapping()} AS _";

        return $this->makeCriteria($command, $criteria);
    }

    public function makeInsertion($table, $columns = null) {
        if ($columns === null) {
            $columns = $table->getColumns();
        }

        $expressions = [];

        foreach ($columns as $column) {
            if ($column->pseudo()) {
                continue;
            }

            $expression = $column->mapping();

            if ($column->multilingual()) {
                foreach (LANGUAGES as $lang) {
                    $expressions[] = "{$expression}__{$lang}";
                }
            } else {
                $expressions[] = $expression;
            }
        }

        $names = implode(', ', $expressions);
        $values = implode(',', array_fill(0, count($expressions), '?'));

        return "INSERT INTO {$table->mapping()} ({$names}) VALUES ({$values})";
    }

    public function makeOrder($command, $columns, $orders) {
        $expressions = [];

        foreach ($orders as $name) {
            if ($name === '?') {
                $expressions[] = 'RANDOM()';
            } else {
                if ($name[0] === '-') {
                    $name = substr($name, 1);
                    $type = 'DESC';
                } else {
                    $type = 'ASC';
                }

                if (key_exists($name, $columns)) {
                    $expressions[] = "\"{$name}\" {$type}";
                }
            }
        }

        if ($expressions) {
            $order = implode(', ', $expressions);

            return "{$command} ORDER BY {$order}";
        }

        return $command;
    }

    public function makePager($command, $size, $page) {
        $offset = $size * ($page - 1);

        return "{$command} LIMIT {$size} OFFSET {$offset}";
    }

    public function makeSelection($table, $criteria, $orders) {
        $expressions = [];

        foreach ($table->getColumns() as $name => $column) {
            if ($column->pseudo()) {
                continue;
            }

            $expression = $column->expression();

            if ($column->multilingual()) {
                foreach (LANGUAGES as $lang) {
                    $expressions["{$name}__{$lang}"] = "{$expression}__{$lang} AS \"{$name}__{$lang}\"";
                }
            } else {
                $expressions[$name] = "{$expression} AS \"{$name}\"";
            }
        }

        $names = implode(', ', $expressions);
        $command = "SELECT {$names} FROM {$table->mapping()} AS _";
        $command = $this->makeRelationJoin($command, $table->getRelations());
        $command = $this->makeCriteria($command, $criteria);

        if ($orders) {
            if ($orders === true) {
                $orders = [$table->ranking() ?? $table->id()];
            }

            $command = $this->makeOrder($command, $expressions, $orders);
        }

        return $command;
    }

    public function makeSequenceSelection() {
        return "SELECT NEXTVAL(?) AS \"value\"";
    }

    public function makeUpdation($table, $criteria, $columns = null) {
        if ($columns === null) {
            $columns = $table->getColumns();
        }

        $expressions = [];

        foreach ($columns as $column) {
            if ($column->pseudo() || $column->readonly()) {
                continue;
            }

            $expression = $column->mapping();

            if ($column->multilingual()) {
                foreach (LANGUAGES as $lang) {
                    $expressions[] = "{$expression}__{$lang} = ?";
                }
            } else {
                $expressions[] = "{$expression} = ?";
            }
        }

        $set = implode(', ', $expressions);
        $command = "UPDATE {$table->mapping()} AS _ SET {$set}";

        return $this->makeCriteria($command, $criteria);
    }

    private function makeRelationJoin($command, $relations) {
        foreach ($relations as $alias => $relation) {
            if (empty($relation['enable']) || $relation['column']->multiple()) {
                continue;
            }

            $column = $relation['column']->expression();
            $foreign = $relation['foreign']->mapping();
            $target = $relation['target']->mapping();

            switch ($relation['type']) {
            case 'association':
                $command = "{$command} LEFT JOIN {$foreign} AS _{$alias} ON (_{$alias}.{$target} = {$column})";
                break;

            case 'composition':
                $selection = "SELECT {$target} AS \"id\", COUNT(*) AS \"count\" FROM {$foreign} GROUP BY {$target}";
                $command = "{$command} LEFT JOIN ({$selection}) AS _{$alias} ON (_{$alias}.id = {$column})";
                break;
            }
        }

        return $command;
    }

}
