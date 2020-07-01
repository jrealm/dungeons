<?php //>

namespace dungeons\db\column;

class RemoteAddress extends Text {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->blankStyle('hidden');
    }

    public function generate($value) {
        return defined('REMOTE_ADDR') ? REMOTE_ADDR : '?';
    }

}
