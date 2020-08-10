<?php //>

namespace dungeons\web\backend;

trait SubList {

    public function available() {
        if ($this->method() === 'POST') {
            $info = pathinfo($this->name());
            $pattern = preg_quote($info['dirname'], '/');

            return preg_match("/^{$pattern}\/[\d-]+\/{$info['basename']}$/", $this->path());
        }

        return false;
    }

}
