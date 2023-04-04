<?php

if (isset($_GET['click']) && $_GET['click'] == true) {
    session_start();
    session_unset();
    session_destroy();
    setcookie('user_email', null, -1, '/');
    setcookie('user_username', null, -1, '/');
    setcookie('doctor_email', null, -1, '/');
    setcookie('doctor_username', null, -1, '/');
    header("Location: ./index");
    die();
} else if (isset($_GET['doctor'])) {
    // doctor login is set, so we want to log in as doctor. So we have to logout of user account

    session_start();
    session_unset();
    session_destroy();
    setcookie('user_email', null, -1, '/');
    setcookie('user_username', null, -1, '/');

    if ($_GET['doctor'] == 'login') {
        header("Location: ./doctor-login");
    } else if ($_GET['doctor'] == 'signup') {
        header("Location: ./doctor-signup");
    }
    die();

} else if (isset($_GET['user'])) {
    // user login is set, so we want to log in as user. So we have to logout of doctor account

    session_start();
    session_unset();
    session_destroy();
    setcookie('doctor_email', null, -1, '/');
    setcookie('doctor_username', null, -1, '/');

    if ($_GET['user'] == 'login') {
        header("Location: ./user-login");
    } else if ($_GET['user'] == 'signup') {
        header("Location: ./user-signup");
    }
    die();
    
} else {
    header("Location: ./");
    die();
}
