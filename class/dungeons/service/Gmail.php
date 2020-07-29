<?php //>

namespace dungeons\service;

use PHPMailer\PHPMailer\PHPMailer;

class Gmail {

    public function execute($args) {
        $mailer = new PHPMailer();

        $mailer->CharSet = 'utf-8';
        $mailer->From = $args['username'];
        $mailer->Host = 'smtp.gmail.com';
        $mailer->Password = $args['password'];
        $mailer->Port = 465;
        $mailer->SMTPAuth = true;
        $mailer->SMTPSecure = 'ssl';
        $mailer->Username = $args['username'];

        $mailer->isHTML(true);
        $mailer->isSMTP();

        $mailer->FromName = $args['from'];
        $mailer->Subject = render($args['subject'], $args);
        $mailer->Body = render($args['content'], $args);

        foreach (preg_split('/[\s;,]/', $args['to'], 0, PREG_SPLIT_NO_EMPTY) as $to) {
            $mailer->AddAddress($to);
        }

        return $mailer->Send();
    }

}
