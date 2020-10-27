<?php //>

namespace dungeons\web\app\member;

use dungeons\web\Controller;
use dungeons\web\MemberAware;
use dungeons\web\Session;

class Logout extends Controller {

    use MemberAware;

    public function available() {
        return ($this->method() === 'POST' && $this->name() === $this->path());
    }

    protected function process($form) {
        $member = $this->member();

        if ($member) {
            Session::remove('Member');

            model('MemberLog')->insert([
                'member_id' => $member['id'],
                'type' => 2, //登出
            ]);
        }

        return ['success' => true, 'type' => 'reload'];
    }

}
