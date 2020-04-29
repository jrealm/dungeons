<?php //>

namespace dungeons\db\column;

use dungeons\db\Column;
use PDO;

class Text extends Column {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->formStyle('text');
        $this->searchStyle('like');
    }

    public function convert($value) {
        return strval($value);
    }

    public function type() {
        return PDO::PARAM_STR;
    }

}
