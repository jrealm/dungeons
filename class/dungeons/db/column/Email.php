<?php //>

namespace dungeons\db\column;

class Email extends Text {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->formStyle('email');
        $this->validation('email');
    }

}
