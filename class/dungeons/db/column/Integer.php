<?php //>

namespace dungeons\db\column;

use PDO;
use dungeons\db\Column;

class Integer extends Column {

    public function convert($value) {
        return intval($value);
    }

    public function type() {
        return PDO::PARAM_INT;
    }

}
