<?php //>

namespace dungeons\db\criterion;

use dungeons\db\Criterion;
use PDO;

class Version implements Criterion {

    protected $value;

    public function __construct($value) {
        $this->value = $value;
    }

    public function bind($statement, $bindings) {
        $bindings[] = $this->value;

        $statement->bindValue(count($bindings), $this->value, PDO::PARAM_INT);

        return $bindings;
    }

    public function make() {
        return "__version__ = ?";
    }

}
