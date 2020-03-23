<?php //>

namespace dungeons\db\column;

class CreateTime extends Timestamp {

    public function generate($value) {
        return date($this->pattern());
    }

}
