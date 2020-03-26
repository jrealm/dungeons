<?php //>

namespace dungeons\db\column;

use PDO;
use dungeons\Attachment;
use dungeons\db\Column;

class File extends Column {

    public function convert($value) {
        return strval($value);
    }

    public function type() {
        return PDO::PARAM_STR;
    }

    public function validate($value) {
        if (Attachment::validate($value, $this->mimeType())) {
            return null;
        }

        return $this->validation();
    }

}
