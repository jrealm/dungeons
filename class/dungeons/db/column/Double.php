<?php //>

namespace dungeons\db\column;

use PDO;
use dungeons\db\Column;

class Double extends Column {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->values['formStyle'] = 'double';
        $this->values['validation'] = 'double';
    }

    public function convert($value) {
        return doubleval($value);
    }

    public function type() {
        return PDO::PARAM_STR;
    }

}
