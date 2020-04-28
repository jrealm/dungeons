<?php //>

namespace dungeons\db\column;

class Id extends Integer {

    use Sequence;

    public function __construct($values = []) {
        parent::__construct($values);

        $this->formStyle('hidden');
        $this->sequence('base_id');

        $this->table()->id($this->name());
    }

    public function generate($value) {
        if (is_null($value)) {
            return $this->nextSequence();
        }

        return $value;
    }

}
