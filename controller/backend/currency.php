<?php //>

return new class() extends dungeons\web\backend\ListController {

    protected function init() {
        $table = table('Currency');
        $table->add('rate_count', 'rate.count');

        $names = [
            'title',
            'code',
            'symbol',
            'rate_count',
            'enable_time',
            'disable_time',
            'ranking',
        ];

        $this->table($table);
        $this->columns($table->getColumns($names));
    }

};
