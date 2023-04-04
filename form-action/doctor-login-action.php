<?php

date_default_timezone_set("Asia/Kolkata");
session_start();

if (isset($_POST['username'])) {

    require_once '../db/db.php';

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    if (isset($_POST['save'])){
        $save = mysqli_real_escape_string($conn, $_POST['save']);
    } else {
        $save = "no";
    }


    $sql = "SELECT * FROM `doctor-login` WHERE `username` = '$username' or `email` = '$username'";

    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        $password_hashed = $row['password'];

        if (password_verify($password, $password_hashed)) {

            if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
                // entered data is email address

                $_SESSION['doctor_email'] = $username;

                $sql1 = "SELECT `username` FROM `doctor-login` WHERE `email` = '$username'";
                $result1 = mysqli_query($conn, $sql1);
                $row1 = mysqli_fetch_assoc($result1);

                $_SESSION['doctor_username'] = $row['username'];
            } else {
                // entered data is not email address but username

                $_SESSION['doctor_username'] = $username;

                $sql1 = "SELECT `email` FROM `doctor-login` WHERE `username` = '$username'";
                $result1 = mysqli_query($conn, $sql1);
                $row1 = mysqli_fetch_assoc($result1);

                $_SESSION['doctor_email'] = $row['email'];
            }

            if ($save == 'yes') {
                setcookie('doctor_email', $_SESSION['doctor_email'], time() + 60 * 60 * 24 * 30, '/');
                setcookie('doctor_username', $_SESSION['doctor_username'], time() + 60 * 60 * 24 * 30, '/');
                // Save cookie for 30 days
            } else {
                setcookie('doctor_email', $_SESSION['doctor_email'], 0, '/');
                setcookie('doctor_username', $_SESSION['doctor_username'], 0, '/');
                // Save cookie till the browser session exists
            }
            header("Location: ../doctor-dashboard");
        } else {
            $_SESSION['credentials'] = 'wrong';
            header("Location: ../doctor-login");
        }
    } else {
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['credentials'] = 'not_registered';
        } else {
            $_SESSION['credentials'] = 'not_found';
        }
        header("Location: ../doctor-login");
    }
} else {
    header("Location: ../doctor-login");
    exit();
}
