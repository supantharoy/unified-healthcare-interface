<?php
require_once '../db/db.php';
date_default_timezone_set("Asia/Kolkata");
require_once '../includes/emailSend.php';
session_start();

$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$blood = mysqli_real_escape_string($conn, $_POST['blood']);
$gender = mysqli_real_escape_string($conn, $_POST['gender']);

$sql = "INSERT INTO `blood-donors` (`name`, `email`, `blood`, `gender`, `posted_on`, `datetime`) VALUES ('$name', '$email', '$blood', '$gender', '" . date("Y-m-d") . "', '" . date("Y-m-d H:i:s") . "')";
$result = mysqli_query($conn, $sql);

$html = '<div style="font-size:1rem"><p>Hello ' . $name . '!</p><p>Thank you for opting to become a blood donor!</p><p>We will inform you whenever a blood recipient tries to get in touch with you.</p><p>Thank you for such a noble act!</p></div>';

include('../smtp/PHPMailerAutoload.php');

emailSend($email, $html, "Thank you choosing to become a blood donor");

$_SESSION['blood_donor'] = "success";

header("Location: ../user-dashboard-blood-donation");
