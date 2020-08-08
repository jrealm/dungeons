<?php //>

namespace dungeons\web\backend\block;

use dungeons\web\backend\BlankController as Controller;
use dungeons\web\backend\SubCreation;

class BlankController extends Controller {

    use SubCreation;

    protected function init() {
        $this->columns($this->table()->getColumns([
            'module',
            'name',
            'enable_time',
            'disable_time',
            'ranking',
        ]));
    }

}
