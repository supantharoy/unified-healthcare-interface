<?php

// dirname(__FILE__ ) = "C:\xampp\htdocs\UHI\includes"

// include(dirname(__FILE__ ) . '/../smtp/PHPMailerAutoload.php');
function emailSend($receiverEmail, $html, $subject)
{
    $adminEmail = 'windowsbackup2001@gmail.com';
    $adminPassword = 'oqkmynuxzlpnxavk';

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->SMTPSecure = "tls";
    $mail->SMTPAuth = true;
    $mail->Username = $adminEmail;
    $mail->Password = $adminPassword;
    $mail->SetFrom($adminEmail, 'UHI India');
    $mail->addAddress($receiverEmail);
    $mail->IsHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $html;
    $mail->Timeout = 20;
    $mail->SMTPOptions = array('ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => false
    ));
    
    $mail->send();
}
