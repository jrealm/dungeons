<?php //>

namespace dungeons\db\column;

use dungeons\Config;

class Time extends AbstractDateTime {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->formStyle('time');
        $this->pattern(Config::get('system.time'));
        $this->validation('time');
    }

}
