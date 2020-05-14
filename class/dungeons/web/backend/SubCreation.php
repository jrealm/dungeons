<?php //>

namespace dungeons\web\backend;

trait SubCreation {

    public function available() {
        if ($this->method() === 'POST') {
            $info = pathinfo($this->name());
            $action = $info['basename'];

            $info = pathinfo($info['dirname']);
            $pattern = preg_quote($info['dirname'], '/');

            return preg_match("/^{$pattern}\/[\d]+\/{$info['basename']}\/{$action}$/", $this->path());
        }

        return false;
    }

}
