<?php //>

namespace dungeons\web\app\member;

use dungeons\web\Controller;
use dungeons\web\MemberAware;

class LoginForm extends Controller {

    use MemberAware;

    public function available() {
        if ($this->method() === 'GET') {
            $pattern = preg_quote($this->name(), '/');

            return preg_match("/^{$pattern}(\/[\w-]+)?$/", $this->path());
        }

        return false;
    }

    protected function init() {
        $this->view('member/login-form.twig');
    }

    protected function process($form) {
        $args = $this->args();
        $path = $args ? base64_urldecode($args[0]) : APP_ROOT;

        $result = ['success' => true, 'path' => $path];

        if ($this->member()) {
            $result['view'] = '302.php';
        }

        return $result;
    }

}
