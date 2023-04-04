<?php

date_default_timezone_set("Asia/Kolkata");
session_start();
require_once '../db/db.php';
require_once '../includes/emailSend.php';

// echo $_SESSION['user_name_temp'], $_SESSION['user_username_temp'], $_SESSION['user_email_temp'], $_SESSION['user_mobile_temp'], $_SESSION['user_password_temp'];

if (isset($_POST['signup'])) {


    if (isset($_SESSION['doctor_name_temp'], $_SESSION['doctor_username_temp'], $_SESSION['doctor_gender_temp'], $_SESSION['doctor_qualification_temp'], $_SESSION['doctor_specialization_temp'], $_SESSION['doctor_email_temp'], $_SESSION['doctor_mobile_temp'], $_SESSION['doctor_password_temp'])) {

        $sql = "INSERT INTO `doctor-login` (`name`, `email`, `mobile`, `username`, `gender`, `qualification`, `specialization`, `other-s`, `experience`, `password`, `created_at`) VALUES ('" . $_SESSION['doctor_name_temp'] . "', '" . $_SESSION['doctor_email_temp'] . "', '" . $_SESSION['doctor_mobile_temp'] . "', '" . $_SESSION['doctor_username_temp'] . "', '" . $_SESSION['doctor_gender_temp'] . "', '" . $_SESSION['doctor_qualification_temp'] . "', '" . $_SESSION['doctor_specialization_temp'] . "', '" . $_SESSION['doctor_other_s_temp'] . "', '" . $_SESSION['doctor_experience_temp'] . "', '" . $_SESSION['doctor_password_temp'] . "', '" . date("Y-m-d H:i:s") . "')";

        mysqli_query($conn, $sql);

        $sql = "INSERT INTO `doctor-availability` (`username`) VALUES ('". $_SESSION['doctor_username_temp'] ."')";
        mysqli_query($conn, $sql);

        setcookie('doctor_email', $_SESSION['doctor_email_temp'],  time() + 60 * 60 * 24 * 30, '/');
        setcookie('doctor_username', $_SESSION['doctor_username_temp'],  time() + 60 * 60 * 24 * 30, '/');

        include('../smtp/PHPMailerAutoload.php');

        $html = '<div style="font-size:1rem"><p>Hi ' . $_SESSION['doctor_name_temp'] . '!</p><p>Thank you for signing up as a doctor on UNIFIED HEALTHCARE INTERFACE, we are so delighted to have you onboard!</p><p>From now on you will receive regular updates on emergency needs and appointment requests. You can also contact any doctor.</p><p>Please visit our website <a href="https://www.unifiedhealthcareinteraface.com">Unified Healthcare Interface</a> for more details!</p></div>';
        $subject = 'Welcome to UNIFIED HEALTHCARE INTERFACE';
        $receiverEmail = $_SESSION['doctor_email_temp'];

        emailSend($receiverEmail, $html, $subject);

        unset($_SESSION['doctor_name_temp'], $_SESSION['doctor_email_temp'], $_SESSION['doctor_mobile_temp'], $_SESSION['doctor_username_temp'], $_SESSION['doctor_gender_temp'], $_SESSION['doctor_qualification_temp'],$_SESSION['doctor_specialization_temp'], $_SESSION['doctor_password_temp'], $_SESSION['doctor_other_s_temp'], $_SESSION['doctor_experience_temp']);

        header("Location: ../doctor-dashboard");
        exit();
    } else {
        header("Location: ../doctor-signup");
        exit();
    }
} else {
    header("Location: ../doctor-signup");
    exit();
}
