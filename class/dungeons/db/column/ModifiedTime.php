<?php //>

namespace dungeons\db\column;

class ModifiedTime extends CreateTime {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->disabled(true);
    }

    public function regenerate($value) {
        return $this->generate($value);
    }

}
