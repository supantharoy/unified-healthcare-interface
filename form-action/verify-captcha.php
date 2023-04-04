<?php 

session_start();
$message = '';
if (isset($_POST['captcha']) && ($_POST['captcha'] != "")) {
    if (strcasecmp($_SESSION['captcha'], $_POST['captcha']) != 0) {
        echo json_encode("invalid");
    } else {
        echo json_encode("success");
    }
} else {
    header("Location: ../user-login");
    exit();
}