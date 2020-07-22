<?php //>

namespace dungeons\db;

use dungeons\Attachment;
use PDO;

class Model {

    const INSERT = 1;
    const UPDATE = 2;
    const DELETE = 3;

    protected $db;
    protected $dialect;
    protected $filter;
    protected $table;

    public function __construct($db, $table) {
        $this->db = $db;
        $this->dialect = $db->getDialect();
        $this->table = $table;
    }

    public function count($conditions = null) {
        $criteria = $this->createCriteria($conditions, $this->filter);
        $command = $this->dialect->makeCountSelection($this->table, $criteria);
        $statement = $this->db->prepare($command);

        $this->execute($statement, $criteria->bind($statement, []));

        return intval($statement->fetch()['count']);
    }

    public function delete($data) {
        $previous = $this->get($data);

        if (!$previous) {
            return null;
        }

        $this->before(self::DELETE, $previous, null);

        $criteria = $this->createCriteria(['id' => $previous['id']]);
        $command = $this->dialect->makeDeletion($this->table, $criteria);
        $statement = $this->db->prepare($command);

        $this->execute($statement, $criteria->bind($statement, []));

        if ($statement->rowCount() === 1) {
            $this->log($previous, null);
            $this->after(self::DELETE, $previous, null);

            return $previous;
        }

        return false;
    }

    public function enableFilter($filter = true) {
        $this->filter = $filter;

        return $this;
    }

    public function find($conditions) {
        $result = $this->query($conditions);

        if (count($result) !== 1) {
            return null;
        }

        return $result[0];
    }

    public function get($data) {
        $id = is_array($data) ? @$data['id'] : $data;

        return $this->find(['id' => $id]);
    }

    public function insert($data) {
        foreach ($this->table->getColumns() as $name => $column) {
            if ($column->pseudo()) {
                continue;
            }

            if ($column->multilingual()) {
                foreach (LANGUAGES as $lang) {
                    $prop = "{$name}__{$lang}";
                    $data[$prop] = $this->forInsert($column, $data, $prop);
                }
            } else {
                $data[$name] = $this->forInsert($column, $data, $name);
            }
        }

        $data = $this->before(self::INSERT, null, $data);

        $bindings = [];
        $command = $this->dialect->makeInsertion($this->table);
        $statement = $this->db->prepare($command);

        foreach ($this->table->getColumns() as $name => $column) {
            if ($column->pseudo()) {
                continue;
            }

            if ($column->multilingual()) {
                foreach (LANGUAGES as $lang) {
                    $value = $data["{$name}__{$lang}"];
                    $bindings[] = $value;

                    $statement->bindValue(count($bindings), $value, $column->type());
                }
            } else {
                $value = $data[$name];
                $bindings[] = $value;

                $statement->bindValue(count($bindings), $value, $column->type());
            }
        }

        $this->execute($statement, $bindings);

        if ($statement->rowCount() === 1) {
            $current = $this->get($data);

            if ($current) {
                $this->log(null, $current);
                $this->after(self::INSERT, null, $current);
            }

            return $current;
        }

        return false;
    }

    public function parents($data) {
        if ($data !== null) {
            $relation = $this->table->getMasterRelation();

            if ($relation) {
                if (@$relation['enable']) {
                    $foreign = $relation['foreign'];
                    $target = $relation['target'];
                } else {
                    $foreign = table($relation['foreign']);
                    $target = $foreign->{$relation['target']};
                }

                $model = $foreign->model();
                $value = is_array($data) ? $data[$relation['column']->name()] : $data;
                $parent = $model->find([$target->equal($value)]);

                if ($parent) {
                    $parents = $model->parents($parent);
                    $parents[] = $parent;

                    return $parents;
                }
            }
        }

        return [];
    }

    public function query($conditions = null, $orders = true, $size = 0, $page = 1) {
        $criteria = $this->createCriteria($conditions, $this->filter);
        $command = $this->dialect->makeSelection($this->table, $criteria, $orders);

        if ($size > 0 && $page > 0) {
            $command = $this->dialect->makePager($command, $size, $page);
        }

        $statement = $this->db->prepare($command);

        $this->execute($statement, $criteria->bind($statement, []));

        return $this->fetch($statement);
    }

    public function toString($data) {
        $title = $this->table->title() ?? 'title';

        if (is_object($title)) {
            return $title->toString($data);
        }

        return isset($this->table->$title) ? "{$data[$title]}" : null;
    }

    public function update($data) {
        $previous = $this->get($data);

        if (!$previous) {
            return null;
        }

        foreach ($this->table->getColumns() as $name => $column) {
            if ($column->pseudo() || $column->readonly()) {
                continue;
            }

            if ($column->multilingual()) {
                foreach (LANGUAGES as $lang) {
                    $prop = "{$name}__{$lang}";
                    $data[$prop] = $this->forUpdate($column, $data, $prop);
                }
            } else {
                $data[$name] = $this->forUpdate($column, $data, $name);
            }
        }

        $data = $this->before(self::UPDATE, $previous, $data);

        $bindings = [];
        $criteria = $this->createCriteria(['id' => $previous['id']]);
        $command = $this->dialect->makeUpdation($this->table, $criteria);
        $statement = $this->db->prepare($command);

        foreach ($this->table->getColumns() as $name => $column) {
            if ($column->pseudo() || $column->readonly()) {
                continue;
            }

            if ($column->multilingual()) {
                foreach (LANGUAGES as $lang) {
                    $value = $data["{$name}__{$lang}"];
                    $bindings[] = $value;

                    $statement->bindValue(count($bindings), $value, $column->type());
                }
            } else {
                $value = $data[$name];
                $bindings[] = $value;

                $statement->bindValue(count($bindings), $value, $column->type());
            }
        }

        $this->execute($statement, $criteria->bind($statement, $bindings));

        if ($statement->rowCount() === 1) {
            $current = $this->get($data);

            if ($current) {
                $this->log($previous, $current);
                $this->after(self::UPDATE, $previous, $current);
            }

            return $current;
        }

        return false;
    }

    protected function after($type, $prev, $curr) {
    }

    protected function before($type, $prev, $curr) {
        return $curr;
    }

    protected function createCriteria($conditions, $filter = false) {
        $criteria = Criteria::createAnd();

        if ($filter) {
            $enable = $this->table->enableTime();

            if ($enable) {
                $column = $this->table->$enable;
                $now = date($column->pattern());

                $conditions[] = $column->notNull();
                $conditions[] = $column->lessThanOrEqual($now);
            }

            $disable = $this->table->disableTime();

            if ($disable) {
                $column = $this->table->$disable;
                $now = date($column->pattern());

                $conditions[] = Criteria::createOr($column->isNull(), $column->greaterThan($now));
            }
        }

        if ($conditions) {
            foreach ($conditions as $name => $value) {
                if ($value instanceof Criterion) {
                    $criteria->add($value);
                } else if (isset($this->table->$name)) {
                    if (is_array($value)) {
                        $criteria->add($this->table->$name->in($value));
                    } else {
                        $criteria->add($this->table->$name->equal($value));
                    }
                }
            }
        }

        return $criteria;
    }

    protected function execute($statement, $bindings) {
        logger('SQL')->debug($statement->queryString, $bindings);

        $statement->execute();
    }

    protected function fetch($statement) {
        $rows = $statement->fetchAll();

        foreach ($this->table->getColumns() as $column) {
            if ($column->pseudo()) {
                continue;
            }

            $rows = array_map([$column, 'pack'], $rows);
        }

        foreach ($rows as &$row) {
            $row['.title'] = $this->toString($row);
        }

        return $rows;
    }

    private function cleanup($data) {
        unset($data['.title']);

        foreach ($this->table->getColumns() as $name => $column) {
            if ($column->multilingual()) {
                unset($data[$name]);
            }
        }

        return $data;
    }

    private function forInsert($column, $data, $name) {
        $value = @$data[$name];

        if ($value === null) {
            $value = $column->default();
        } else {
            if ($value instanceof Attachment) {
                $value->save();
            }

            $value = $column->convert($value);
        }

        return $column->generate($value);
    }

    private function forUpdate($column, $data, $name) {
        $value = @$data[$name];

        if ($value !== null) {
            if ($value instanceof Attachment) {
                $value->save();
            }

            $value = $column->convert($value);
        }

        return $column->regenerate($value);
    }

    private function log($prev, $curr) {
        if (!$this->table->traceable()) {
            return;
        }

        if ($prev) {
            $prev = $this->cleanup($prev);
            $dataId = $prev['id'];

            if ($curr) {
                $diff = [];

                foreach ($this->table->getColumns() as $name => $column) {
                    if ($column->pseudo() || $column->readonly()) {
                        continue;
                    }

                    if ($column->multilingual()) {
                        foreach (LANGUAGES as $lang) {
                            $prop = "{$name}__{$lang}";

                            if ($prev[$prop] !== $curr[$prop]) {
                                $diff[$prop] = $curr[$prop];
                            }
                        }
                    } else {
                        if ($prev[$name] !== $curr[$name]) {
                            $diff[$name] = $curr[$name];
                        }
                    }
                }

                $type = self::UPDATE;
                $prev = json_encode($prev, JSON_UNESCAPED_UNICODE);
                $curr = json_encode($diff, JSON_UNESCAPED_UNICODE);
            } else {
                $type = self::DELETE;
                $prev = json_encode($prev, JSON_UNESCAPED_UNICODE);
                $curr = null;
            }
        } else {
            if ($curr) {
                $curr = $this->cleanup($curr);
                $dataId = $curr['id'];

                $type = self::INSERT;
                $prev = null;
                $curr = json_encode($curr, JSON_UNESCAPED_UNICODE);
            } else {
                return;
            }
        }

        $statement = $this->db->prepare('INSERT INTO base_manipulation_log (type, controller, user_id, member_id, ip, data_type, data_id, previous, current) VALUES (?,?,?,?,?,?,?,?,?)');
        $statement->bindValue(1, $type, PDO::PARAM_INT);
        $statement->bindValue(2, constant('CONTROLLER_NAME'), PDO::PARAM_STR);
        $statement->bindValue(3, @constant('USER_ID'), PDO::PARAM_INT);
        $statement->bindValue(4, @constant('MEMBER_ID'), PDO::PARAM_INT);
        $statement->bindValue(5, @constant('REMOTE_ADDR'), PDO::PARAM_STR);
        $statement->bindValue(6, $this->table->name(), PDO::PARAM_STR);
        $statement->bindValue(7, $dataId, PDO::PARAM_INT);
        $statement->bindValue(8, $prev, PDO::PARAM_STR);
        $statement->bindValue(9, $curr, PDO::PARAM_STR);
        $statement->execute();
    }

}
