<?php

require 'app/Library/PHPMailer/src/PHPMailer.php';
require 'app/Library/PHPMailer/src/SMTP.php';
require 'app/Library/PHPMailer/src/Exception.php';

class M_Mailer
{
    private $mail;
    public function __construct()
    {
        $this->mail = new PHPMailer\PHPMailer1\PHPMailer();
    }

    public function sendMail($sendTo, $subject, $body)
    {
        $this->mail->isSMTP();
        $this->mail->SMTPAuth = true;
        $this->mail->Host = 'mail.mdl.my.id';
        $this->mail->Port = 465;
        $this->mail->SMTPSecure     = "ssl";
        $this->mail->Username = 'cs@mdl.my.id';
        $this->mail->Password = 'a123654b';
        $this->mail->From = 'cs@mdl.my.id';
        $this->mail->FromName = "MDL Laundry";
        $this->mail->addAddress($sendTo);
        $this->mail->Subject = $subject;
        $this->mail->Body = $body;
        $this->mail->send();
    }
}
