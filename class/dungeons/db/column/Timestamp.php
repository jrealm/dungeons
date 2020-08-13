<?php //>

namespace dungeons\db\column;

class Timestamp extends AbstractDateTime {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->formStyle('timestamp');
        $this->pattern(cfg('system.timestamp'));
        $this->validation('timestamp');
    }

}
