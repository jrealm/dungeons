<?php //>

namespace dungeons\db;

use dungeons\utility\ValueObject;

abstract class Column extends ValueObject {

    protected static $defaults = [
        'mapping' => 'name',
    ];

    public function associate($alias, $foreign, $target = 'id', $super = false, $filter = []) {
        $this->table()->register([
            'alias' => $alias,
            'type' => 'association',
            'super' => $super,
            'column' => $this,
            'foreign' => $foreign,
            'target' => $target,
            'filter' => $filter,
        ]);

        if ($super) {
            $this->invisible(true);
        }

        return $this->association($alias);
    }

    public function between($from, $to) {
        return new criterion\Between($this, [$from, $to]);
    }

    public function composite($alias, $foreign, $target) {
        $this->table()->register([
            'alias' => $alias,
            'type' => 'composition',
            'column' => $this,
            'foreign' => $foreign,
            'target' => $target,
        ]);

        return $this;
    }

    abstract public function convert($value);

    public function equal($value) {
        return new criterion\Equal($this, [$value]);
    }

    public function expression($prefix = null) {
        if ($prefix === null) {
            $prefix = $this->alias();
        }

        return "_{$prefix}.{$this->mapping()}";
    }

    public function generate($value) {
        return $value;
    }

    public function greaterThan($value) {
        return new criterion\GreaterThan($this, [$value]);
    }

    public function greaterThanOrEqual($value) {
        return new criterion\GreaterThanOrEqual($this, [$value]);
    }

    public function in(...$values) {
        if (count($values) === 1 && is_array($values[0])) {
            $values = $values[0];
        }

        return new criterion\In($this, $values);
    }

    public function isNull() {
        return new criterion\IsNull($this, []);
    }

    public function lessThan($value) {
        return new criterion\LessThan($this, [$value]);
    }

    public function lessThanOrEqual($value) {
        return new criterion\LessThanOrEqual($this, [$value]);
    }

    public function like($value, $insensitive = false) {
        if ($insensitive) {
            return new criterion\ILike($this, [strtolower($value)]);
        } else {
            return new criterion\Like($this, [$value]);
        }
    }

    public function notBetween($from, $to) {
        return new criterion\NotBetween($this, [$from, $to]);
    }

    public function notEqual($value) {
        return new criterion\NotEqual($this, [$value]);
    }

    public function notIn(...$values) {
        if (count($values) === 1 && is_array($values[0])) {
            $values = $values[0];
        }

        return new criterion\NotIn($this, $values);
    }

    public function notLike($value, $insensitive = false) {
        if ($insensitive) {
            return new criterion\NotILike($this, [strtolower($value)]);
        } else {
            return new criterion\NotLike($this, [$value]);
        }
    }

    public function notNull() {
        return new criterion\NotNull($this, []);
    }

    public function pack($row) {
        if ($this->multilingual()) {
            $name = $this->name();

            $row[$name] = $row[$name . '__' . LANGUAGE];
        }

        return $row;
    }

    public function regenerate($value) {
        return $value;
    }

    abstract public function type();

}
