<?php //>

namespace dungeons\db\column;

class Textarea extends Text {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->formStyle('textarea');
    }

}
