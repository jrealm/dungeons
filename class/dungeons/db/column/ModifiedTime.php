<?php //>

namespace dungeons\db\column;

class ModifiedTime extends CreateTime {

    public function regenerate($value) {
        return $this->generate($value);
    }

}
