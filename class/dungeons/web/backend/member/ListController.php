<?php //>

namespace dungeons\web\backend\member;

use dungeons\web\backend\ListController as Controller;

class ListController extends Controller {

    protected function init() {
        $table = table('Member');
        $table->add('prefix', 'country.prefix');

        if ($this->hasPermission('member/substitute')) {
            $table->username->listStyle('link')->template('member/substitute/{{ id }}');
        }

        $names = [
            'username',
            'prefix',
            'mobile',
            'mail',
            'create_time',
            'disabled',
        ];

        $this->table($table);
        $this->columns($table->getColumns($names));
    }

}
