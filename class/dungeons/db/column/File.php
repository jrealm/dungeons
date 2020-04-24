<?php //>

namespace dungeons\db\column;

use dungeons\db\Column;
use PDO;

class File extends Column {

    public function convert($value) {
        return strval($value);
    }

    public function type() {
        return PDO::PARAM_STR;
    }

}
