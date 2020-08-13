<?php //>

namespace dungeons\db\column;

class Date extends AbstractDateTime {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->formStyle('date');
        $this->pattern(cfg('system.date'));
        $this->validation('date');
    }

}
