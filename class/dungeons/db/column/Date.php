<?php //>

namespace dungeons\db\column;

use dungeons\Config;

class Date extends AbstractDateTime {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->values['formStyle'] = 'date';
        $this->values['pattern'] = Config::get('system.date');
        $this->values['validation'] = 'date';
    }

}
