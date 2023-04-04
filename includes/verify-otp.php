
<?php

date_default_timezone_set("Asia/Kolkata");
require_once '../db/db.php';
session_start();

$type = mysqli_real_escape_string($conn, $_POST['type']);

if ($type == 'email-otp') {

    $otp = mysqli_real_escape_string($conn, $_POST['otp']);

    if ($otp != $_SESSION['email_otp']) {
        echo json_encode("invalid");
    } else if (strtotime(date("Y-m-d H:i:s")) - strtotime($_SESSION['email_otp_sent_at']) > 900) {
        echo json_encode("expired");
    } else if ($otp == $_SESSION['email_otp']) {
        echo json_encode("success");
    }

} else if ($type == 'mobile-otp') {

    $otp = mysqli_real_escape_string($conn, $_POST['otp']);

    if ($otp != $_SESSION['mobile_otp']) {
        echo json_encode("invalid");
    } else if (strtotime(date("Y-m-d H:i:s")) - strtotime($_SESSION['mobile_otp_sent_at']) > 900) {
        echo json_encode("expired");
    } else if ($otp == $_SESSION['mobile_otp']) {
        echo json_encode("success");
    }
    
} else {
    header("Location: ../doctor-signup");
    exit();
}
