<?php //>

namespace dungeons\db\column;

use dungeons\Config;

class Time extends AbstractDateTime {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->values['formStyle'] = 'time';
        $this->values['pattern'] = Config::get('system.time');
        $this->values['validation'] = 'time';
    }

}
