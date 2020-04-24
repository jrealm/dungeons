<?php //>

namespace dungeons\db\column;

use PDO;
use dungeons\db\Column;

class Text extends Column {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->values['formStyle'] = 'text';
    }

    public function convert($value) {
        return strval($value);
    }

    public function type() {
        return PDO::PARAM_STR;
    }

}
