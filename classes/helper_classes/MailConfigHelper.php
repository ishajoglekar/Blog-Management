<?php 

/*
idhar kidhar bhi paga ho hum use karte hai an autoload khud se layaega
*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__."/../../vendor/autoload.php";
// require_once ""

class MailConfigHelper
{
    public static function getMailer():PHPMailer{

        $mail = new PHPMailer();
        // $mail->SMTPDebug = 4;
        $mail->isSMTP();
        $mail->Host = "smtp.mailtrap.io";
        $mail->SMTPAuth = true;
        $mail->Username ="8617a1b22a70fb";
        $mail->Password ="992a23fff0a7e5";
        $mail->Port = 2525;
        $mail->SMTPSecure = 'tls';
        $mail->isHTML(true);
        
        $mail->setFrom("admin@sl.com","<SL>");
        return $mail;

    }
    

}



?>  