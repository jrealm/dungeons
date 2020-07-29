<?php //>

namespace dungeons\web;

class UserController extends Controller {

    use UserAware;

    public function available() {
        return ($this->method() === 'POST' && $this->name() === $this->path());
    }

    public function execute() {
        if ($this->authorize()) {
            parent::execute();
        }
    }

    protected function authorize() {
        $user = $this->user();

        if ($user) {
            define('USER_ID', $user['id']);

            return true;
        }

        if (defined('AJAX') && AJAX) {
            header('HTTP/1.1 401 Unauthorized');
        } else {
            $path = base64_urlencode($_SERVER['REQUEST_URI']);

            header('Location: ' . APP_ROOT . 'backend/login/' . $path);
        }

        return false;
    }

    protected function loadSetting() {
        if (defined('APP_DATA')) {
            $file = APP_DATA . 'setting/' . $this->user()['id'];

            if (is_file($file) && is_readable($file)) {
                return json_decode(file_get_contents($file), true);
            }
        }

        return [];
    }

}
