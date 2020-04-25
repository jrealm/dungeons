<?php //>

namespace dungeons\db\column;

use dungeons\db\Column;
use PDO;

class Integer extends Column {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->formStyle('integer');
        $this->validation('integer');
    }

    public function convert($value) {
        return intval($value);
    }

    public function type() {
        return PDO::PARAM_INT;
    }

}
