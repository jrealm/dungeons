<?php //>

namespace dungeons\db\column;

class EnableTime extends Timestamp {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->default(date($this->pattern()));
        $this->tab('other');

        $this->table()->enableTime($this->name());
    }

}
