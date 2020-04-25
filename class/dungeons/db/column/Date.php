<?php //>

namespace dungeons\db\column;

use dungeons\Config;

class Date extends AbstractDateTime {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->formStyle('date');
        $this->pattern(Config::get('system.date'));
        $this->validation('date');
    }

}
