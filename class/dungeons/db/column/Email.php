<?php //>

namespace dungeons\db\column;

class Email extends Text {

    public function validate($value) {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return parent::validate($value);
        }

        return $this->validation();
    }

}
