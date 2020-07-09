<?php //>

namespace dungeons\service;

class MitakeSms {

    public function execute($args) {
        $args['phone'] = $args['prefix'] . ltrim($args['phone'], '0');

        $response = file_get_contents(render($args['url'], $args));

        if (preg_match('/statuscode=(\d+)/', $response, $matches) && $matches[1] < 5) {
            model('SmsLog')->insert(['receiver' => $args['phone'], 'content' => $args['text'], 'response' => $response]);

            return true;
        }

        return false;
    }

}
