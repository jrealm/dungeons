<?php //>

namespace dungeons\db\column;

use PDO;
use dungeons\db\Column;

abstract class AbstractDateTime extends Column {

    public function convert($value) {
        return $value;
    }

    public function type() {
        return PDO::PARAM_STR;
    }

}
