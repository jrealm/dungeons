<?php //>

return new class() extends dungeons\web\backend\ListController {

    protected function init() {
        $table = table('MemberPassportAuth');
        $table->add('username', 'member.username');

        $names = [
            'username',
            'last_name',
            'first_name',
            'id_number',
            'create_time',
            'approve_time',
            'status',
        ];

        $this->table($table);
        $this->columns($table->getColumns($names));
    }

    protected function preprocess($form) {
        $conditions = $this->conditions();

        if (!$conditions) {
            $this->conditions(['status' => 1]);
            $this->criteria($this->table()->status->equal(1));
            $this->table()->status->inSearch(true);
        }

        return parent::preprocess($form);
    }

};
