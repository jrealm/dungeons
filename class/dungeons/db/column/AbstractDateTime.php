<?php //>

namespace dungeons\db\column;

use dungeons\db\Column;
use PDO;

abstract class AbstractDateTime extends Column {

    public function convert($value) {
        return $value;
    }

    public function type() {
        return PDO::PARAM_STR;
    }

}
