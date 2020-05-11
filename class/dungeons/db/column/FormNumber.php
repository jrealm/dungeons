<?php //>

namespace dungeons\db\column;

class FormNumber extends Text {

    use Sequence;

    public function __construct($values = []) {
        parent::__construct($values);

        $this->length(3);
        $this->pattern('Ymd');
    }

    public function generate($value) {
        if ($value === null) {
            $date = date($this->pattern());
            $prefix = $this->prefix();
            $sequence = str_pad($this->nextSequence(), $this->length(), '0', STR_PAD_LEFT);

            return "{$prefix}{$date}{$sequence}";
        }

        return $value;
    }

}
