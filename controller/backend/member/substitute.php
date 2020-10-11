<?php //>

use dungeons\web\Session;

return new class() extends dungeons\web\BackendController {

    public function available() {
        if ($this->method() === 'POST') {
            $pattern = preg_quote($this->name(), '/');

            return preg_match("/^{$pattern}\/[\w-]+$/", $this->path());
        }

        return false;
    }

    protected function process($form) {
        $member = model('Member')->queryById($this->args()[0]);

        if (!$member) {
            return ['error' => 'error.DataNotFound'];
        }

        Session::set('Member', $member);

        return [
            'success' => true,
            'type' => 'open',
            'path' => APP_ROOT,
        ];
    }

};
