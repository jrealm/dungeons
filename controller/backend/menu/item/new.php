<?php //>

return new class() extends dungeons\web\backend\BlankController {

    public function available() {
        if ($this->method() === 'POST') {
            return preg_match("/^\/backend\/menu\/[\d]+\/item\/new$/", $this->path());
        }

        return false;
    }

    protected function init() {
        $this->table(table('SubMenu'));
    }

};
