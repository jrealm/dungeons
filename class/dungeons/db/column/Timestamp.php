<?php //>

namespace dungeons\db\column;

use dungeons\Config;

class Timestamp extends AbstractDateTime {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->values['formStyle'] = 'timestamp';
        $this->values['pattern'] = Config::get('system.timestamp');
        $this->values['validation'] = 'timestamp';
    }

}
