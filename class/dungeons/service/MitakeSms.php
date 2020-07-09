<?php //>

namespace dungeons\service;

class MitakeSms {

    public function execute($args) {
        if ($args['prefix'] !== '+886') {
            $args['phone'] = "{$args['prefix']}{$args['phone']}";
        }

        $response = file_get_contents(render($args['url'], $args));

        if (preg_match('/statuscode=(\d+)/', $response, $matches) && $matches[1] < 5) {
            model('SmsLog')->insert(['receiver' => $args['phone'], 'content' => $args['text'], 'response' => $response]);

            return true;
        }

        return false;
    }

}
