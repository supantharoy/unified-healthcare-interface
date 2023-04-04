
<?php

date_default_timezone_set("Asia/Kolkata");
session_start();
require_once '../db/db.php';
require_once '../includes/emailSend.php';

$type = mysqli_real_escape_string($conn, $_POST['type']);


// If the OTP is to be sent to Email
if ($type == 'doctor-email') {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $name = $_SESSION['doctor_name_temp'];

    $otp = random_int(111111, 999999);

    $_SESSION['email_otp'] = $otp;
    $_SESSION['email_otp_sent_at'] = date("Y-m-d H:i:s");
    $_SESSION['doctor_email_temp'] = $email;

    include('../smtp/PHPMailerAutoload.php');

    // $adminEmail = "unifiedhealthcareinterface@gmail.com";
    // $adminPassword = "ouvmfpvwtvxvxtpu";

    $html = "<p style=\"font-size:1rem\">Hello $name,</p> <p style=\"font-size:1rem\">Thank you for signing up as UNIFIED HEALTHCARE INTERFACE doctor.<br/>Your OTP for Email Verification is valid for 15 minutes.</p> <p style=\"font-size:1rem\">You can find the OTP below -</p> <div style=\"font-size:2rem\";\"margin:20px auto\">$otp</div>";

    emailSend($email, $html, $subject);

    echo json_encode("success");


    // If the OTP is to be sent to Mobile Number
} else if ($type == 'user-email') {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $name = $_SESSION['user_name_temp'];

    $otp = random_int(111111, 999999);

    $_SESSION['email_otp'] = $otp;
    $_SESSION['email_otp_sent_at'] = date("Y-m-d H:i:s");
    $_SESSION['user_email_temp'] = $email;

    include('../smtp/PHPMailerAutoload.php');

    // $adminEmail = "unifiedhealthcareinterface@gmail.com";
    // $adminPassword = "ouvmfpvwtvxvxtpu";

    $html = "<p style=\"font-size:1rem\">Hello $name,</p> <p style=\"font-size:1rem\">Thank you for signing up on UNIFIED HEALTHCARE INTERFACE.<br/>Your OTP for Email Verification is valid for 15 minutes.</p> <p style=\"font-size:1rem\">You can find the OTP below -</p> <div style=\"font-size:2rem\";\"margin:20px auto\">$otp</div>";

    emailSend($email, $html, $subject);

    echo json_encode("success");

} else if ($type == 'doctor-mobile') {

    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);

    $otp = random_int(111111, 999999);

    $_SESSION['mobile_otp'] = $otp;
    $_SESSION['mobile_otp_sent_at'] = date("Y-m-d H:i:s");
    $_SESSION['doctor_mobile_temp'] = $mobile;

    $fields = array(
        "sender_id" => "TXTIND",
        // "message" => "VALID FOR 15 MINUTES!\n\nHello, " . $name . "!\n\nThank you for signing up with UNIFIED HEALTHCARE INTERFACE.\n\nYour OTP for mobile number verification is " . $otp,
        "message" => "VALID FOR 15 MINUTES!\n\nYour OTP for UHI mobile number verification is " . $otp,
        "language" => "english",
        "route" => "v3",
        // "route" => "q",
        "numbers" => $mobile,
    );

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($fields),
        CURLOPT_HTTPHEADER => array(
            "authorization: maJyRYoK9EteHk8v13FDIOnhixPqdNSrz7CufLbXM4lwVAQ6W54UtfHusCRWj5lpeMJLV1BdvrYynPDF",
            "accept: */*",
            "cache-control: no-cache",
            "content-type: application/json"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo json_encode("error");
    } else {
        echo json_encode("success");
    }
} else if ($type == 'user-mobile') {

    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);

    $otp = random_int(111111, 999999);

    $_SESSION['mobile_otp'] = $otp;
    $_SESSION['mobile_otp_sent_at'] = date("Y-m-d H:i:s");
    $_SESSION['user_mobile_temp'] = $mobile;

    $fields = array(
        "sender_id" => "TXTIND",
        // "message" => "VALID FOR 15 MINUTES!\n\nHello, " . $name . "!\n\nThank you for signing up with UNIFIED HEALTHCARE INTERFACE.\n\nYour OTP for mobile number verification is " . $otp,
        "message" => "VALID FOR 15 MINUTES!\n\nYour OTP for UHI mobile number verification is " . $otp,
        "language" => "english",
        "route" => "v3",
        // "route" => "q",
        "numbers" => $mobile,
    );

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($fields),
        CURLOPT_HTTPHEADER => array(
            "authorization: maJyRYoK9EteHk8v13FDIOnhixPqdNSrz7CufLbXM4lwVAQ6W54UtfHusCRWj5lpeMJLV1BdvrYynPDF",
            "accept: */*",
            "cache-control: no-cache",
            "content-type: application/json"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo json_encode("error");
    } else {
        echo json_encode("success");
    }
} else {
    header("Location: ../doctor-signup");
    exit();
}
