<?php //>

namespace dungeons\db\column;

class DisableTime extends Timestamp {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->table()->disableTime($this);
    }

}
