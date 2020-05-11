<?php //>

namespace dungeons\db;

use PDO;

class Connection {

    public static function getInstance() {
        static $instance;

        if ($instance === null && defined('DB_NAME') && defined('DB_USER')) {
            $instance = new Connection(DB_NAME, DB_USER, @constant('DB_PASSWORD'));
        }

        return $instance;
    }

    private $delegate;
    private $dialect;
    private $objects = [];
    private $prepares = [];

    public function __construct($name, $user, $password) {
        $this->delegate = new PDO($name, $user, $password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING,
        ]);

        $this->dialect = new Dialect();
    }

    public function begin() {
        if ($this->delegate->inTransaction()) {
            return;
        }

        $this->delegate->beginTransaction();
    }

    public function commit() {
        if ($this->delegate->inTransaction()) {
            $this->delegate->commit();
        }
    }

    public function getDialect() {
        return $this->dialect;
    }

    public function getModel($table) {
        $name = $table->name();

        if (!key_exists($name, $this->objects)) {
            $className = "{$table->namespace()}\\{$name}";

            if (class_exists($className)) {
                $this->objects[$name] = new $className($this, $table);
            } else {
                $this->objects[$name] = new Model($this, $table);
            }
        }

        return $this->objects[$name];
    }

    public function nextSequence($name) {
        $command = $this->dialect->makeSequenceSelection();

        $sequence = $this->prepare($command);
        $sequence->bindValue(1, $name, PDO::PARAM_STR);
        $sequence->execute();

        return $sequence->fetch()['value'];
    }

    public function prepare($statement) {
        if (!key_exists($statement, $this->prepares)) {
            $this->prepares[$statement] = $this->delegate->prepare($statement);
        }

        return $this->prepares[$statement];
    }

    public function rollback() {
        if ($this->delegate->inTransaction()) {
            $this->delegate->rollBack();
        }
    }

}
