<?php //>

namespace dungeons\db\column;

class CreateTime extends Timestamp {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->values['blankStyle'] = 'hidden';
    }

    public function generate($value) {
        return date($this->pattern());
    }

}
