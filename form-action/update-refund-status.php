<?php

date_default_timezone_set("Asia/Kolkata");
session_start();
require_once '../db/db.php';
require_once '../includes/emailSend.php';

$appointmentId = mysqli_real_escape_string($conn, $_POST['id']);
$status = mysqli_real_escape_string($conn, $_POST['status']);

$sql = "UPDATE `appointment` SET `refund` = $status WHERE `id` = '$appointmentId';";
$result = mysqli_query($conn, $sql);

$sql = "SELECT * FROM `appointment` WHERE `id` = '$appointmentId';";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$sql = "SELECT * FROM `time-slots` WHERE `slot` = '" . $row['appointment_time'] . "';";
$result = mysqli_query($conn, $sql);
$time_slot = mysqli_fetch_assoc($result);

$sql = "SELECT * FROM `doctor-login` WHERE `username` = '" . $row['doctor'] . "';";
$result = mysqli_query($conn, $sql);
$doctor = mysqli_fetch_assoc($result);

$sql = "SELECT * FROM `user-login` WHERE `username` = '" . $row['user'] . "';";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);


// Send mail to user

include('../smtp/PHPMailerAutoload.php');

$url = "http://localhost/UHI/contact";

$html = '<div style="font-size:1rem"><p>Hello ' . $user['name'] . '!</p><p>We have initiated a refund of &#x20B9; 1500 for cancellation of your appointment with Dr. ' . $doctor['name'] . ' scheduled on ' . $row['appointment_date']  . ' between ' . $time_slot['time'] . '</p><p>We apologize for the inconvenience caused. </p><p>The refund will be processed and successfully transferred within 2-3 working days.</p><p>In case of delay, you can contact us with your <strong>Appointment ID</strong> = '. $appointmentId .' at <a href=' . $url . ' >Contact Us</a></p></div>';

$subject = 'Refund Initiated for Appointment ID = '. $appointmentId;
$receiverEmail = $user['email'];

emailSend($receiverEmail, $html, $subject);

$_SESSION['refund'] = 'initiated';

echo json_encode("success");
