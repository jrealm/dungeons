<?php //>

namespace dungeons\web;

class MemberController extends Controller {

    public function execute() {
        if ($this->authorize()) {
            parent::execute();
        }
    }

    protected function authorize() {
        $member = Session::get('Member');

        if ($member) {
            $current = model('Member')->queryById($member['id']);

            if ($current && $current['password'] === $member['password']) {
                define('MEMBER_ID', $current['id']);

                Session::set('Member', $current);

                $this->member($current);

                return true;
            }

            Session::remove('Member');
        }

        if (defined('AJAX') && AJAX) {
            header('HTTP/1.1 401 Unauthorized');
        } else {
            $path = base64_urlencode($_SERVER['REQUEST_URI']);

            header('Location: ' . APP_ROOT . 'login/' . $path);
        }

        return false;
    }

}
