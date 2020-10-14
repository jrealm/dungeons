<?php //>

namespace dungeons\web;

class AppController extends MemberController {

    use TwigView;

    public function available() {
        return ($this->method() === 'POST' && $this->name() === $this->path());
    }

}
