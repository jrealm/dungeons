<?php //>

namespace dungeons\db\column;

class Id extends AbstractSequence {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->values['formStyle'] = 'hidden';
        $this->values['sequence'] = 'base_id';

        $this->table()->id($this->name());
    }

    public function generate($value) {
        if (is_null($value)) {
            return $this->nextSequence();
        }

        return $value;
    }

}
