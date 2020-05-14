<?php //>

return new class() extends dungeons\web\backend\BlankController {

    use dungeons\web\backend\SubCreation;

    protected function init() {
        $table = table('Block');

        $names = [
            'module',
            'name',
            'enable_time',
            'disable_time',
            'ranking',
        ];

        $this->table($table);
        $this->columns($table->getColumns($names));
    }

};
