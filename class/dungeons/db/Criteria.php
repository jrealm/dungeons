<?php //>

namespace dungeons\db;

class Criteria implements Criterion {

    public static function createAnd(...$criteria) {
        return new Criteria($criteria, ' AND ');
    }

    public static function createOr(...$criteria) {
        return new Criteria($criteria, ' OR ');
    }

    private $criteria;
    private $operator;

    private function __construct($criteria, $operator) {
        $this->criteria = $criteria;
        $this->operator = $operator;
    }

    public function add($criterion) {
        $this->criteria[] = $criterion;

        return $this;
    }

    public function bind($statement, $bindings) {
        foreach ($this->criteria as $criterion) {
            $bindings = $criterion->bind($statement, $bindings);
        }

        return $bindings;
    }

    public function make() {
        $expressions = [];

        foreach ($this->criteria as $criterion) {
            $expression = $criterion->make();

            if ($expression !== false) {
                $expressions[] = $expression;
            }
        }

        if ($expressions) {
            return '(' . implode($this->operator, $expressions) . ')';
        }

        return false;
    }

}
