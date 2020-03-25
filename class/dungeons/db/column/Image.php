<?php //>

namespace dungeons\db\column;

class Image extends File {

    public function validate($value) {
        if (is_array($value)) {
            if (strstr(@$value['mimeType'], '/', true) === 'image') {
                return null;
            } else {
                @unlink($value['file']);
            }
        } else if (is_string($value)) {
            if (preg_match('/^data:image\//', $value)) {
                return null;
            }

            if (defined('APP_FILES') && file_exists(APP_FILES . $value)) {
                return null;
            }
        }

        return $this->validation();
    }

}
