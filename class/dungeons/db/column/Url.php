<?php //>

namespace dungeons\db\column;

class Url extends Text {

    public function validate($value) {
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return parent::validate($value);
        }

        return $this->validation();
    }

}
