<?php //>

return new class() extends dungeons\web\backend\BlankController {

    use dungeons\web\backend\BlockItem;

    public function available() {
        if ($this->method() === 'POST') {
            return preg_match("/^\/backend\/page\/block\/[\d]+\/item\/new$/", $this->path());
        }

        return false;
    }

};
