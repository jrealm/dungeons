<?php //>

namespace dungeons\web;

trait UserAware {

    private $user;

    public function user() {
        if ($this->user === null) {
            $this->user = false;

            $user = Session::get('User');

            if ($user) {
                $current = model('User')->queryById($user['id']);

                if ($current && $current['password'] === $user['password']) {
                    Session::set('User', $current);

                    $this->user = $current;
                } else {
                    Session::remove('User');
                }
            }
        }

        return $this->user;
    }

}
