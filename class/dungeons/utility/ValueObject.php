<?php //>

namespace dungeons\utility;

class ValueObject {

    protected $values;

    public function __construct($values = []) {
        $this->values = $values;
    }

    public function __call($name, $arguments) {
        if ($arguments) {
            $this->values[$name] = $arguments[0];

            return $this;
        }

        if (key_exists($name, $this->values)) {
            return $this->values[$name];
        }

        if (isset(static::$defaults) && key_exists($name, static::$defaults)) {
            return $this->{static::$defaults[$name]}();
        }

        return null;
    }

}
