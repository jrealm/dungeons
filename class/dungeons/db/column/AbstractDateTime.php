<?php //>

namespace dungeons\db\column;

use DateTime;
use PDO;
use dungeons\db\Column;

abstract class AbstractDateTime extends Column {

    public function convert($value) {
        return $value;
    }

    public function type() {
        return PDO::PARAM_STR;
    }

    public function validate($value) {
        $pattern = $this->pattern();
        $datetime = DateTime::createFromFormat($pattern, $value);

        if (!$datetime || $datetime->format($pattern) !== $value) {
            return $this->validation();
        }

        return null;
    }

}
