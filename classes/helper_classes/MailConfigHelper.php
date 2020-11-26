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
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username   = 'isha.joglekar@somaiya.edu';                  
        $mail->Password   = 'Arch@ngels'; 
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->isHTML(true);
        // $mail->setFrom("muskanaswani25@gmail.com", "<SL>");
        // $mail->addAddress("ijoglekar16@gmail.com");
         // $mail->addCC("abc@gmail.com");
        // $mail->Subject = "First mail from PHP mailer";
        
        $mail->setFrom("isha.joglekar@somaiya.edu","KJSCE - Blog Management");
        // Util::dd($mail);
        return $mail;

    }
    

}



?>  