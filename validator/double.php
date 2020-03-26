<?php //>

return new class() {

    public function validate($value, $options) {
        return (filter_var($value, FILTER_VALIDATE_FLOAT) !== false);
    }

};
