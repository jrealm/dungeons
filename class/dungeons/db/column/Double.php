<?php //>

namespace dungeons\db\column;

use PDO;
use dungeons\db\Column;

class Double extends Column {

    public function convert($value) {
        return doubleval($value);
    }

    public function type() {
        return PDO::PARAM_STR;
    }

}
