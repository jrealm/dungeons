<?php //>

namespace dungeons\db\column;

class UserId extends Integer {

    public function generate($value) {
        return defined('USER_ID') ? USER_ID : null;
    }

    public function regenerate($value) {
        return $this->generate($value);
    }

}
