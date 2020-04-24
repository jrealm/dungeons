<?php //>

namespace dungeons\db\column;

class Url extends Text {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->values['formStyle'] = 'url';
        $this->values['validation'] = 'url';
    }

}
