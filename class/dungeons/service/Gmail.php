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
        $mailer->Subject = $args['subject'];
        $mailer->Body = render($args['content'], $args);

        $mailer->AddAddress($args['to']);

        return $mailer->Send();
    }

}
