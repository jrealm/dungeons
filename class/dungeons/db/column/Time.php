<?php //>

namespace dungeons\db\column;

class Time extends AbstractDateTime {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->formStyle('time');
        $this->pattern(cfg('system.time'));
        $this->validation('time');
    }

}
