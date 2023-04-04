<?php

session_start();
date_default_timezone_set("Asia/Kolkata");
require_once '../db/db.php';
require_once '../includes/emailSend.php';


if (isset($_POST['email'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $sql = "UPDATE `doctor-login` SET `password_change_request` = '1' WHERE `email` = '$email';";
    mysqli_query($conn, $sql);

    $email_encoded = base64_encode($email);

    include('../smtp/PHPMailerAutoload.php');

    $html = '<div style="font-size:1rem"><p>We have received a reset password request for your UNIFIED HEALTCARE INTERFACE account.</p><You>If this wasn\'t you, please ignore this mail. </p><p>You can reset the password using the link below </p><p><a href="http://localhost/UHI/doctor-reset-password?secret='.$email_encoded.'">Reset Password</a></p></div>';

    $subject = 'RESET PASSWORD REQUEST';

    emailSend($email, $html, $subject);

    echo json_encode("success");

} else {
    header("Location: ../doctor-login");
    exit();
}
