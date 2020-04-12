<?php //>

return new class() extends dungeons\web\backend\ListController {

    public function available() {
        if ($this->method() === 'POST') {
            $info = pathinfo($this->name());
            $pattern = preg_quote($info['dirname'], '/');

            return preg_match("/^{$pattern}\/[\d]+\/{$info['basename']}$/", $this->path());
        }

        return false;
    }

    protected function init() {
        $table = table('Block');
        $table->add('item_count', 'item.count');

        $names = [
            'module',
            'name',
            'item_count',
            'enable_time',
            'disable_time',
            'ranking',
        ];

        $this->table($table);
        $this->columns($table->getColumns($names));
    }

};
