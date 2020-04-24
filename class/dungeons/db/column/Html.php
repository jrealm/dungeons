<?php //>

namespace dungeons\db\column;

class Html extends Text {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->values['formStyle'] = 'html';
    }

}
