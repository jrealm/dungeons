<?php //>

namespace dungeons\db;

use dungeons\db\column\Counter;
use dungeons\db\column\Id;
use dungeons\utility\ValueObject;
use Exception;

class Table extends ValueObject {

    private $columns = [];
    private $relations = [];

    public function __construct($mapping, $traceable = true, $namespace = 'dungeons\model') {
        parent::__construct(['mapping' => $mapping, 'namespace' => $namespace]);

        if ($traceable) {
            $this->traceable(true);
        }

        $this->add('id', Id::class)->readonly(true)->required(true);
    }

    public function __get($name) {
        if (key_exists($name, $this->columns)) {
            return $this->columns[$name];
        }

        throw new Exception("Column `{$this->name()}`.`{$name}` not found.");
    }

    public function __isset($name) {
        return key_exists($name, $this->columns);
    }

    public function __set($name, $value) {
        throw new Exception('Unsupported operation.');
    }

    public function __unset($name) {
        throw new Exception('Unsupported operation.');
    }

    public function add($name, $typeName) {
        if (key_exists($name, $this->columns)) {
            throw new Exception("Column `{$this->name()}`.`{$name}` exists.");
        }

        if (class_exists($typeName)) {
            $column = new $typeName(['name' => $name, 'table' => $this]);
        } else {
            $tokens = preg_split('/\./', $typeName, 2);

            if (count($tokens) !== 2) {
                throw new Exception("Invalid \$typeName `{$typeName}`.");
            }

            list($alias, $column) = $tokens;

            if (!key_exists($alias, $this->relations)) {
                throw new Exception("Relation `{$alias}` of `{$this->name()}` not found.");
            }

            $relation = &$this->relations[$alias];

            if (empty($relation['enable'])) {
                $foreign = table($relation['foreign']);

                $relation['target'] = $foreign->{$relation['target']};
                $relation['foreign'] = $foreign;
                $relation['enable'] = true;
            }

            if ($relation['type'] === 'composition') {
                $column = new Counter(['name' => $column]);
            } else {
                $column = $relation['foreign']->$column;
            }

            $column = new ColumnWrapper($alias, $column, $relation);
        }

        $this->columns[$name] = $column;

        return $column;
    }

    public function getColumns($names = null) {
        if ($names) {
            $columns = [];

            foreach ($names as $name) {
                $columns[$name] = $this->columns[$name];
            }

            return $columns;
        }

        return $this->columns;
    }

    public function getMasterRelation() {
        $master = false;

        foreach ($this->relations as $relation) {
            if (@$relation['super']) {
                if ($master) {
                    return false;
                }

                $master = $relation;
            }
        }

        return $master;
    }

    public function getRelations() {
        return $this->relations;
    }

    public function model() {
        return Connection::getInstance()->getModel($this);
    }

    public function register($relation) {
        $alias = $relation['alias'];

        if (key_exists($alias, $this->relations)) {
            throw new Exception("Relation `{$alias}` of `{$this->name()}` exists.");
        }

        $this->relations[$alias] = $relation;
    }

    public function remove(...$names) {
        foreach ($names as $name) {
            if (key_exists($name, $this->columns)) {
                unset($this->columns[$name]);
            } else {
                throw new Exception("Column `{$this->name()}`.`{$name}` not found.");
            }
        }
    }

}
