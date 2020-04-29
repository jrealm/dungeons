<?php //>

namespace dungeons\db\column;

use dungeons\db\Column;
use PDO;

abstract class AbstractDateTime extends Column {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->searchStyle('between');
    }

    public function convert($value) {
        return $value;
    }

    public function type() {
        return PDO::PARAM_STR;
    }

}
