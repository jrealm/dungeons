<?php //>

namespace dungeons\db\column;

use PDO;
use dungeons\db\Column;

class File extends Column {

    public function convert($value) {
        if (is_array($value)) {
            return @$value['path'];
        }

        return $value;
    }

    public function type() {
        return PDO::PARAM_STR;
    }

}
