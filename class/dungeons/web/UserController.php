<?php //>

namespace dungeons\web;

class UserController extends Controller {

    public function available() {
        return ($this->method() === 'POST' && $this->name() === $this->path());
    }

    public function execute() {
        if ($this->authorize()) {
            parent::execute();
        }
    }

    protected function authorize() {
        $user = Session::get('User');

        if ($user) {
            $current = model('User')->queryById($user['id']);

            if ($current && $current['password'] === $user['password']) {
                define('USER_ID', $current['id']);

                Session::set('User', $current);

                $this->user($current);

                return true;
            }

            Session::remove('User');
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
