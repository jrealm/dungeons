<?php //>

namespace dungeons\db\column;

class Image extends File {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->formStyle('image');
        $this->mimeType('image\/[\w]+');
        $this->validation('image');
    }

}
