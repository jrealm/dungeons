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

    protected function preprocess($form) {
        $relation = $this->table()->getMasterRelation();

        if ($relation) {
            $form[$relation['column']->name()] = $this->args()[0];
        }

        return $form;
    }

}
