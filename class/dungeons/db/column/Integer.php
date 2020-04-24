<?php //>

namespace dungeons\db\column;

use PDO;
use dungeons\db\Column;

class Integer extends Column {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->values['formStyle'] = 'integer';
        $this->values['validation'] = 'integer';
    }

    public function convert($value) {
        return intval($value);
    }

    public function type() {
        return PDO::PARAM_INT;
    }

}
