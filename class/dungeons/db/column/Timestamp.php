<?php //>

namespace dungeons\db\column;

use dungeons\Config;

class Timestamp extends AbstractDateTime {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->formStyle('timestamp');
        $this->pattern(Config::get('system.timestamp'));
        $this->validation('timestamp');
    }

}
