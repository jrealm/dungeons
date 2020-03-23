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

    public function validate($value) {
        if (filter_var($value, FILTER_VALIDATE_FLOAT) === false) {
            return $this->validation();
        }

        return null;
    }

}
