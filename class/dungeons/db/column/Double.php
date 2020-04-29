<?php //>

namespace dungeons\db\column;

use dungeons\db\Column;
use PDO;

class Double extends Column {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->formStyle('double');
        $this->searchStyle('between');
        $this->validation('double');
    }

    public function convert($value) {
        return doubleval($value);
    }

    public function type() {
        return PDO::PARAM_STR;
    }

}
