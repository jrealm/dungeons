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

    public function validate($value) {
        if (filter_var($value, FILTER_VALIDATE_INT) === false) {
            return $this->validation();
        }

        return null;
    }

}
