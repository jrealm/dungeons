<?php //>

namespace dungeons\db\column;

use dungeons\web\Session;

class CreatorName extends Text {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->blankStyle('hidden');
    }

    public function generate($value) {
        if (defined('USER_ID')) {
            return Session::get('User')['username'];
        }

        if (defined('MEMBER_ID')) {
            return Session::get('Member')['username'];
        }

        return null;
    }

}
