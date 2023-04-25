
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

$sql = "INSERT INTO `blood-donor-contact` (`donor_id`, `name`, `email`, `subject`, `message`, `datetime`) VALUES ('$donor_id', '$name', '$email', '$subject', '$message', '" . date("Y-m-d H:i:s") . "')";

mysqli_query($conn, $sql);

$sql = "SELECT * FROM `blood-donors` WHERE `id` = '$donor_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);


$html = '<div style="font-size:1rem"><p>Hello ' . $row['name'] . '!</p><p>' . $name . ' has sent you an email regarding donation of ' . $row['blood'] . ' blood.</p><p>You can find their email message below -</p><p style="border:1px solid black; border-radius:10px; padding:10px 20px; width:300px">' . $message . '</p><p>You can contact them back on their email id: ' . $email . '</p></div>';

include('../smtp/PHPMailerAutoload.php');

emailSend($row['email'], $html, "Blood Donation: " . $subject);

$_SESSION['blood_donor_contact'] = "success";

header("Location: ../user-dashboard-blood-donors");
