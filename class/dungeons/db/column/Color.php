<?php //>

namespace dungeons\db\column;

class Color extends Text {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->formStyle('color');
    }

}
