<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    private $mail;

    function __construct()
    {
        $this->mail = new PHPMailer(true);

        $this->mail->isSMTP();
        $this->mail->Host       = MAIL_HOST;
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = MAIL_USER;
        $this->mail->Password   = MAIL_PASS;
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mail->Port       = 465;
    }

    public function send($data)
    {
        try {
            if (empty($data['from'])) {
                $data['from']['mail'] = MAIL_USER;
                $data['from']['name'] = MAIL_USERNAME;
            }
            $this->mail->setFrom($data['from']['mail'], $data['from']['name']);

            if (!empty($data['to'])) {
                if (!empty($data['to'][0]) && is_array($data['to'][0])) {
                    foreach ($data['to'] as $user) {
                        $this->mail->addAddress($user['mail'], $user['name']);
                    }
                } else {
                    $this->mail->addAddress($data['to']['mail'], $data['to']['name']);
                }
            }
            if (!empty($data['subject'])) $this->mail->Subject = $data['subject'];

            $this->mail->isHTML(true);
            if (!empty($data['body'])) $this->mail->Body = $data['body'];

            $this->mail->send();

            return true;
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }

    public function template($template, $data)
    {
        extract($data);

        $currentRoot = dirname(__DIR__, 2);
        $template = $currentRoot . '/app/assets/mails/' . $template . ".php";

        if (is_file($template)) {
            ob_start();
            include $template;
            return ob_get_clean();
        }

        return false;
    }
}
