<?php //>

namespace dungeons\db\column;

class Image extends File {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->values['formStyle'] = 'image';
        $this->values['mimeType'] = 'image\/[\w]+';
        $this->values['validation'] = 'image';
    }

}
