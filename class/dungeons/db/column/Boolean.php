<?php //>

namespace dungeons\db\column;

use PDO;
use dungeons\db\Column;

class Boolean extends Column {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->values['formStyle'] = 'radio';
        $this->values['options'] = 'yes-no';
    }

    public function convert($value) {
        if (is_string($value)) {
            return filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }

        return boolval($value);
    }

    public function type() {
        return PDO::PARAM_BOOL;
    }

}
