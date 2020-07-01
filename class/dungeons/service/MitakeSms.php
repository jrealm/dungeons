<?php //>

namespace dungeons\service;

class MitakeSms {

    public function execute($args) {
        $response = file_get_contents(render($args['url'], $args));

        if (preg_match('/statuscode=(\d+)/', $response, $matches) && $matches[1] < 5) {
            model('SmsLog')->insert(['receiver' => $args['phone'], 'content' => $args['text']]);

            return true;
        }

        return false;
    }

}
