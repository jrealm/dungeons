<?php //>

use dungeons\utility\Fn;

return new class() {

    public function validate($value, $options) {
        return Fn::is_tw_id($value);
    }

};
