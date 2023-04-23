
<?php
require_once '../db/db.php';
date_default_timezone_set("Asia/Kolkata");
require_once '../includes/emailSend.php';
session_start();

$donor_id = mysqli_real_escape_string($conn, $_POST['donor_id']);
$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$subject = mysqli_real_escape_string($conn, $_POST['subject']);
$message = mysqli_real_escape_string($conn, $_POST['message']);

$sql = "INSERT INTO `organ-donor-contact` (`donor_id`, `name`, `email`, `subject`, `message`) VALUES ('$donor_id', '$name', '$email', '$subject', '$message')";

$result = mysqli_query($conn, $sql);

// run sql to get info of donor and use them to send email

$html = '<div style="font-size:1rem"><p>Hello ' . $name . '!</p><p>Thank you for opting to become an organ donor!</p><p>We will inform you whenever an organ recipient tries to get in touch with you.</p><p>Thank you for such a noble act!</p></div>';

include('../smtp/PHPMailerAutoload.php');

emailSend($email, $html, "Thank you choosing to become an organ donor");

$_SESSION['organ_donor'] = "success";

//header("Location: ../user-dashboard-organ-donation");
