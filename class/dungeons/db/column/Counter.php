<?php //>

namespace dungeons\db\column;

class Counter extends Integer {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->default(0);
        $this->formStyle('counter');
    }

}
