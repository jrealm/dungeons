<?php //>

return new class() extends dungeons\web\backend\ListController {

    protected function init() {
        $table = table('MemberLog');
        $table->add('username', 'member.username');

        $this->table($table);
    }

};
