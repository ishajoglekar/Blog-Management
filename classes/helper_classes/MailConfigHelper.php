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
        $mail->Username ="ebe5664e4df46f";
        // $mail->Username ="a2b6ad841062d6";
        $mail->Password ="50aa536d61308e";
        // $mail->Password ="d83be9220e7ff7";
        $mail->Port = 2525;
        $mail->SMTPSecure = 'tls';
        $mail->isHTML(true);
        // $mail->setFrom("muskanaswani25@gmail.com", "<SL>");
        // $mail->addAddress("ijoglekar16@gmail.com");
         // $mail->addCC("abc@gmail.com");
        // $mail->Subject = "First mail from PHP mailer";
        
        $mail->setFrom("admin@sl.com","<SL>");
        return $mail;

    }
    

}



?>  