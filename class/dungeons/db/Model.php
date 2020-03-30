<?php //>

namespace dungeons\db;

use PDO;
use dungeons\Attachment;

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
            $value = @$data[$name];

            if (is_null($value)) {
                $value = $column->default();
            } else {
                if ($value instanceof Attachment) {
                    $value->save();
                }

                $value = $column->convert($value);
            }

            $data[$name] = $column->generate($value);
        }

        $data = $this->before(self::INSERT, null, $data);

        $bindings = [];
        $command = $this->dialect->makeInsertion($this->table);
        $statement = $this->db->prepare($command);

        foreach ($this->table->getColumns() as $name => $column) {
            $value = $data[$name];
            $bindings[] = $value;

            $statement->bindValue(count($bindings), $value, $column->type());
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

        return $data[isset($this->table->$title) ? $title : 'id'];
    }

    public function update($data) {
        $previous = $this->get($data);

        if (!$previous) {
            return null;
        }

        foreach ($this->table->getColumns() as $name => $column) {
            if ($column->readonly()) {
                continue;
            }

            $value = @$data[$name];

            if (!is_null($value)) {
                if ($value instanceof Attachment) {
                    $value->save();
                }

                $value = $column->convert($value);
            }

            $data[$name] = $column->regenerate($value);
        }

        $data = $this->before(self::UPDATE, $previous, $data);

        $bindings = [];
        $criteria = $this->createCriteria(['id' => $previous['id']]);
        $command = $this->dialect->makeUpdation($this->table, $criteria);
        $statement = $this->db->prepare($command);

        foreach ($this->table->getColumns() as $name => $column) {
            if ($column->readonly()) {
                continue;
            }

            $value = $data[$name];
            $bindings[] = $value;

            $statement->bindValue(count($bindings), $value, $column->type());
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
                $now = date($enable->pattern());

                $conditions[] = $enable->notNull();
                $conditions[] = $enable->lessThanOrEqual($now);
            }

            $disable = $this->table->disableTime();

            if ($disable) {
                $now = date($disable->pattern());

                $conditions[] = Criteria::createOr($disable->isNull(), $disable->greaterThan($now));
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
        return $statement->fetchAll();
    }

    private function log($prev, $curr) {
        if (!$this->table->traceable()) {
            return;
        }

        if ($prev) {
            $dataId = $prev['id'];

            if ($curr) {
                $diff = [];

                foreach ($this->table->getColumns() as $name => $column) {
                    if ($column->readonly() || $prev[$name] === $curr[$name]) {
                        continue;
                    }

                    $diff[$name] = $curr[$name];
                }

                $type = self::UPDATE;
                $prev = json_encode($prev);
                $curr = json_encode($diff);
            } else {
                $type = self::DELETE;
                $prev = json_encode($prev);
                $curr = null;
            }
        } else {
            if ($curr) {
                $dataId = $curr['id'];

                $type = self::INSERT;
                $prev = null;
                $curr = json_encode($curr);
            } else {
                return;
            }
        }

        $statement = $this->db->prepare('INSERT INTO base_manipulation_log (type, action, user_id, member_id, ip, data_type, data_id, previous, current) VALUES (?,?,?,?,?,?,?,?,?)');
        $statement->bindValue(1, $type, PDO::PARAM_INT);
        $statement->bindValue(2, constant('ACTION_NAME'), PDO::PARAM_STR);
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
