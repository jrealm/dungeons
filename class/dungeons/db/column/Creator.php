<?php //>

namespace dungeons\db\column;

class Creator extends Integer {

    public function generate($value) {
        return defined('USER_ID') ? USER_ID : (defined('MEMBER_ID') ? MEMBER_ID : null);
    }

}
