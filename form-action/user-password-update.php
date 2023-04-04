<?php

session_start();
date_default_timezone_set("Asia/Kolkata");
require_once '../db/db.php';
require_once '../includes/emailSend.php';


if (isset($_POST['submit'])) {

    $secret = mysqli_real_escape_string($conn, $_POST['secret']);
    $email = base64_decode($secret);

    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "UPDATE `user-login` SET `password_change_request` = '0' WHERE `email` = '$email';";
    mysqli_query($conn, $sql);

    $sql = "UPDATE `user-login` SET `password` = '$password' WHERE `email` = '$email';";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['password_change'] = 'success';
    } else {
        $_SESSION['password_change'] = 'failure';
    }

    $html = '<div style="font-size:1rem"><p>Your password for UNIFIED HEALTHCARE INTERFACE has been updated successfully!</p><p>You can login with the new credentials now</p></div>';

    $subject = 'PASSWORD UPDATED SUCCESSFULLY';

    include('../smtp/PHPMailerAutoload.php');
    emailSend($email, $html, $subject);

    header("Location: ../user-login");
    exit();
} else {
    header("Location: ../user-login");
    exit();
}
