<?php //>

namespace dungeons\db\column;

class Counter extends Integer {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->formStyle('counter');
    }

    public function expression($prefix = null) {
        $expression = parent::expression($prefix);

        return "COALESCE({$expression}, 0)";
    }

}
