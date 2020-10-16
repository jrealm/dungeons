<?php //>

return new class() extends dungeons\web\backend\ListController {

    protected function init() {
        $table = table('MasterCard');
        $table->add('username', 'member.username');

        $this->table($table);
    }

};
