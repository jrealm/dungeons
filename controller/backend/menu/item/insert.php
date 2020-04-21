<?php //>

return new class() extends dungeons\web\backend\InsertController {

    public function available() {
        if ($this->method() === 'POST') {
            return preg_match("/^\/backend\/menu\/[\d]+\/item\/insert$/", $this->path());
        }

        return false;
    }

    protected function init() {
        $this->table(table('SubMenu'));
    }

};
