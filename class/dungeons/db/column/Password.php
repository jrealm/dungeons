<?php //>

namespace dungeons\db\column;

class Password extends Text {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->formStyle('password');
    }

}
