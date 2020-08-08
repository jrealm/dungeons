<?php //>

namespace dungeons\web\backend\block;

use dungeons\web\backend\BlockForm;
use dungeons\web\backend\GetController as Controller;

class GetController extends Controller {

    use BlockForm;

    protected function init() {
        $this->columns($this->table()->getColumns([
            'id',
            'page_id',
            'module',
            'name',
            'enable_time',
            'disable_time',
            'ranking',
        ]));
    }

}
