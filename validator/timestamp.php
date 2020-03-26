<?php //>

return new class() {

    public function validate($value, $options) {
        $pattern = $options->pattern();
        $datetime = DateTime::createFromFormat($pattern, $value);

        return ($datetime && $datetime->format($pattern) === $value);
    }

};
