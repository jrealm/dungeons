<?php //>

namespace dungeons\db\column;

class ModifiedDate extends CreateDate {

    public function regenerate($value) {
        return $this->generate($value);
    }

}
