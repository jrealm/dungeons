<?php //>

namespace dungeons\db\column;

class Ranking extends Serial {

    public function __construct($values = []) {
        parent::__construct($values);

        $this->sequence('base_ranking');
        $this->tab('other');

        $this->table()->ranking($this->name());
    }

    public function regenerate($value) {
        return $this->generate($value);
    }

}
