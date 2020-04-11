<?php //>

return new class() extends dungeons\web\backend\BlankController {

    public function available() {
        if ($this->method() === 'POST') {
            return preg_match("/^\/backend\/page\/[\d]+\/blocks\/new$/", $this->path());
        }

        return false;
    }

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
