<?php //>

return new class() extends dungeons\web\backend\InsertController {

    public function available() {
        if ($this->method() === 'POST') {
            return preg_match("/^\/backend\/page\/blocks\/[\d]+\/items\/insert$/", $this->path());
        }

        return false;
    }

    protected function init() {
        $this->table(table('BlockItem'));
    }

};
