<?php //>

use dungeons\web\Session;

return new class() extends dungeons\web\Action {

    public function __construct() {
        parent::__construct();

        $this->view('backend/login-form.twig');
    }

    public function available() {
        if ($this->method() === 'GET') {
            $pattern = preg_quote($this->name(), '/');

            return preg_match("/^{$pattern}(\/[\w-]+)?$/", $this->path());
        }

        return false;
    }

    protected function process($form) {
        $args = $this->args();
        $path = $args ? base64_urldecode($args[0]) : (APP_ROOT . 'backend/');

        $result = ['success' => true, 'path' => $path];

        if (Session::get('User')) {
            $result['view'] = '302.php';
        }

        return $result;
    }

};
