<?php //>

namespace dungeons\db\column;

class Modifier extends Creator {

    public function regenerate($value) {
        return $this->generate($value);
    }

}
