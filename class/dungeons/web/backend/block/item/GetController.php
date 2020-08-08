<?php //>

namespace dungeons\web\backend\block\item;

use dungeons\web\backend\BlockForm;
use dungeons\web\backend\GetController as Controller;

class GetController extends Controller {

    use BlockForm;

    protected function init() {
        $this->columns($this->table()->getColumns([
            'id',
            'block_id',
            'enable_time',
            'disable_time',
            'ranking',
        ]));
    }

}
