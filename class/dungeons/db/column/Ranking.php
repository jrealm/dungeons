<?php //>

namespace dungeons\db\column;

class Ranking extends Serial {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->formStyle('hidden');
        $this->sequence('base_ranking');

        $this->table()->ranking($this->name());
    }

    public function regenerate($value) {
        return $this->generate($value);
    }

}
