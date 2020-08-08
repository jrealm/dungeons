<?php //>

namespace dungeons\web;

trait MemberAware {

    private $member;

    public function member() {
        if ($this->member === null) {
            $this->member = false;

            $member = Session::get('Member');

            if ($member) {
                $current = model('Member')->queryById($member['id']);

                if ($current && $current['password'] === $member['password']) {
                    Session::set('Member', $current);

                    $this->member = $current;
                } else {
                    Session::remove('Member');
                }
            }
        }

        return $this->member;
    }

}
