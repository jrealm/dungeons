<?php //>

use dungeons\{Config,Message};

return new class() extends dungeons\web\backend\BlankController {

    use dungeons\web\backend\BlockItem;

    public function available() {
        if ($this->method() === 'POST') {
            return preg_match("/^\/backend\/page\/blocks\/[\d]+\/items\/new$/", $this->path());
        }

        return false;
    }

};
