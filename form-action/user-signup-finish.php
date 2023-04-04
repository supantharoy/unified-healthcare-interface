<?php

date_default_timezone_set("Asia/Kolkata");
session_start();
require_once '../db/db.php';
require_once '../includes/emailSend.php';

// echo $_SESSION['user_name_temp'], $_SESSION['user_username_temp'], $_SESSION['user_email_temp'], $_SESSION['user_mobile_temp'], $_SESSION['user_password_temp'];

if (isset($_POST['signup'])) {


    if (isset($_SESSION['user_name_temp'], $_SESSION['user_username_temp'], $_SESSION['user_gender_temp'], $_SESSION['user_email_temp'], $_SESSION['user_mobile_temp'], $_SESSION['user_password_temp'])) {

        $sql = "INSERT INTO `user-login` (`name`, `email`, `mobile`, `username`, `gender`, `password`, `created_at`) VALUES ('" . $_SESSION['user_name_temp'] . "', '" . $_SESSION['user_email_temp'] . "', '" . $_SESSION['user_mobile_temp'] . "', '" . $_SESSION['user_username_temp'] . "', '" . $_SESSION['user_gender_temp'] . "', '" . $_SESSION['user_password_temp'] . "', '". date("Y-m-d H:i:s") ."')";

        mysqli_query($conn, $sql);

        setcookie('user_email', $_SESSION['user_email_temp'],  time() + 60 * 60 * 24 * 30, '/');
        setcookie('user_username', $_SESSION['user_username_temp'],  time() + 60 * 60 * 24 * 30, '/');

        include('../smtp/PHPMailerAutoload.php');

        $html = '<div style="font-size:1rem"><p>Hi '.$_SESSION['user_name_temp'].'!</p><p>Thank you for signing up with UNIFIED HEALTHCARE INTERFACE, we are so delighted to have you onboard!</p><p>From now on you will receive regular updates on emergency needs. You can also contact any doctor or book an appointment.</p><p>Please visit our website <a href="https://www.unifiedhealthcareinteraface.com">Unified Healthcare Interface</a> for more details!</p></div>';
        $subject = 'Welcome to UNIFIED HEALTHCARE INTERFACE';
        $receiverEmail = $_SESSION['user_email_temp'];

        emailSend($receiverEmail, $html, $subject);

        unset($_SESSION['user_name_temp'], $_SESSION['user_email_temp'], $_SESSION['user_mobile_temp'], $_SESSION['user_username_temp'], $_SESSION['user_gender_temp'], $_SESSION['user_password_temp']);

        header("Location: ../user-dashboard");
        exit();
    } else {
        header("Location: ../user-signup");
        exit();
    }
} else {
    header("Location: ../user-signup");
    exit();
}
