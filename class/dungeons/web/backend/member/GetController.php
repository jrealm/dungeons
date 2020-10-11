<?php //>

namespace dungeons\web\backend\member;

use dungeons\web\backend\GetController as Controller;

class GetController extends Controller {

    protected function init() {
        $table = table('Member');
        $table->password->required(false);

        $this->table($table);
    }

}
