<?php
require_once './db/db.php';
date_default_timezone_set("Asia/Kolkata");
include('./smtp/PHPMailerAutoload.php');

function emailSend($receiverEmail, $html, $subject)
{
    $adminEmail = 'unifiedhealthcareinterface@gmail.com';
    $adminPassword = 'ouvmfpvwtvxvxtpu';

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->SMTPSecure = "tls";
    $mail->SMTPAuth = true;
    $mail->Username = $adminEmail;
    $mail->Password = $adminPassword;
    $mail->SetFrom($adminEmail);
    $mail->addAddress($receiverEmail);
    $mail->IsHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $html;
    $mail->SMTPOptions = array('ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => false
    ));

    $mail->send();
}

if (isset($_POST['name'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $comments = mysqli_real_escape_string($conn, $_POST['comments']);

    $sql = "INSERT INTO `contact` (`name`, `email`, `subject`, `comments`) VALUES ('$name', '$email', '$subject', '$comments')";

    $result = mysqli_query($conn, $sql);

    $html1 = "<table border=1 style=\"border-collapse:collapse;font-size:1rem;text-align:center\"><thead><tr><th style=\"background-color: #cfcfcf; padding:10px 20px\">Name</th><th style=\"background-color: #cfcfcf; padding:10px 20px\">Email</th><th style=\"background-color: #cfcfcf; padding:10px 20px\">Subject</th><th style=\"background-color: #cfcfcf; padding:10px 20px\">Comments</th></tr></thead><tbody><tr><td style=\"padding:10px 20px\">$name</td><td style=\"padding:10px 20px\">$email</td><td style=\"padding:10px 20px\">$subject</td><td style=\"padding:10px 20px\">$comments</td></tr></tbody></table>";

    $html2 = "<p style=\"font-size:1rem\">Hello $name,</p> <p style=\"font-size:1rem\">Thank you for contacting the UNIFIED HEALTHCARE INTERFACE!<br/>We will get back to you as soon as they can. Meanwhile check out our other services.</p><p style=\"font-size:1rem\"> Thanks for choosing us!<br/></p><p style=\"font-size:1rem\">Regards,<br/>UNIFIED HEALTHCARE INTERFACE</p>";


    $adminEmail = "unifiedhealthcareinterface@gmail.com";
    $adminPassword = "ouvmfpvwtvxvxtpu";

    emailSend($email, $html2, "Thank you for contacting UHI");

    emailSend($adminEmail, $html1, "New Contact Form Data");

    $alert = 'success';
}
