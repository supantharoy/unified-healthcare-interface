
<?php
date_default_timezone_set("Asia/Kolkata");
session_start();
require_once '../db/db.php';
require_once '../includes/emailSend.php';

$appointmentId = mysqli_real_escape_string($conn, $_POST['id']);

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

include('../smtp/PHPMailerAutoload.php');

// Send mail to user

$url = "http://localhost/UHI/user-dashboard-appointment?open=cancelled";

$html = '<div style="font-size:1rem"><p>Hello ' . $user['name'] . '!</p><p>We are extremely sorry to inform you that your Appointment with Dr. ' . $doctor['name'] . ' on ' . $row['appointment_date']  . ' between ' . $time_slot['time'] . ' has been cancelled due to some unavoidable circumstances.</p><p>We apologize for the inconvenience caused. </p><p>You can opt for a full refund or you can book another appointment at no additional cost. (In case the new appointment costs less the extra amount will be refunded within 2-3 working days) </p><p>You can check the <a href=' . $url . ' >Cancelled Appointments</a></p></div>';

$subject = 'Unfortunately your Appointment was cancelled!';
$receiverEmail = $user['email'];

emailSend($receiverEmail, $html, $subject);

echo json_encode("success");
