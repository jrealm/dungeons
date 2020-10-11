<?php //>

return new class() extends dungeons\web\backend\ListController {

    protected function init() {
        $table = table('MemberLog');
        $table->add('username', 'member.username');

        $names = [
            'username',
            'type',
            'ip',
            'create_time',
        ];

        $this->table($table);
        $this->columns($table->getColumns($names));
    }

};
