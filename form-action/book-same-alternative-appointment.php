<?php

date_default_timezone_set("Asia/Kolkata");
session_start();
require_once '../db/db.php';
require_once '../includes/emailSend.php';
include('../zoom/config.php');
include('../zoom/api.php');

if (isset($_POST['same-alternate-booking'])) {

    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $newdoctor = mysqli_real_escape_string($conn, $_POST['newdoctor']);
    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $timeslot = mysqli_real_escape_string($conn, $_POST['appointment_time']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);

    //echo var_dump($_POST);

    /*
    $sql = "INSERT INTO `appointment` (`doctor`, `user`, `appointment_date`, `appointment_time`, `booked_at_date`, `booked_at_datetime`) VALUES ('$doctor', '$user', '$date', '$slot', '" . date("Y-m-d") . "', '" . date("Y-m-d H:i:s") . "');";
    mysqli_query($conn, $sql);*/

    /*
    if (mysqli_query($conn, $sql)) {
        header('Location: ../user-dashboard-appointment?success=check-email');
    } else {
        header('Location: ../user-dashboard-appointment?failure=server-error');
    }
*/
    $sql1 = "SELECT * FROM `doctor-login` WHERE `username` = '$newdoctor'";
    $result1 = mysqli_query($conn, $sql1);
    $doctor = mysqli_fetch_assoc($result1);

    $sql2 = "SELECT * FROM `user-login` WHERE `username` = '$user'";
    $result2 = mysqli_query($conn, $sql2);
    $user = mysqli_fetch_assoc($result2);

    $sql3 = "SELECT * FROM `time-slots` WHERE `slot` = '$timeslot'";
    $result3 = mysqli_query($conn, $sql3);
    $slot = mysqli_fetch_assoc($result3);


    $arr['topic'] = 'Appointment with Dr. ' . $doctor['name'];
    $arr['start_date'] = $date;
    // $arr['start_date']=date('2021-05-16 00:02:30', strtotime($time));
    $arr['duration'] = 30;
    $arr['type'] = '2';
    $result = createMeeting($arr);

    /*
    $start_time = explode(" - ", $slot['time']);

    $start_time_in_24_hour_format  = date("H:i:s", strtotime($start_time[0]));

    $start_date_time = date('Y-m-d H:i:s', strtotime("$date $start_time_in_24_hour_format"));
    */

    $sql1 = "INSERT INTO `appointment` (`doctor`, `user`, `appointment_date`, `appointment_time`, `booked_at_date`, `booked_at_datetime`, `start_url`, `join_url`, `start_date_time`) SELECT '$newdoctor', `user`, `appointment_date`, `appointment_time`, '" . date("Y-m-d") . "', '" . date("Y-m-d H:i:s") . "', '". $result->start_url ."', '". $result->join_url ."', `start_date_time` FROM `appointment` WHERE id = '$id';";

    //$result1 = mysqli_query($conn, $sql1);

    mysqli_query($conn, $sql1);
    $alternate_id = mysqli_insert_id($conn);

    $sql = "UPDATE `appointment` SET `alternative` = '$alternate_id' WHERE `id` = '" . $id . "'";
    mysqli_query($conn, $sql);


    include('../smtp/PHPMailerAutoload.php');

    // Send mail to user

    $html = '<div style="font-size:1rem"><p>Hello ' . $user['name'] . '!</p><p>Your alternative Appointment with Dr. ' . $doctor['name'] . ' has been confirmed!</p><p>Your appointment is scheduled on ' . date("d-m-Y", strtotime($date)) . ' at ' . $slot['time'] . '</p><p>Once again, we apologize for the inconvenience caused.</p><p>Use the button below to join the meeting at the scheduled time.</p><p style="padding-top:20px"><a href="' . $result->join_url . '" style="background-color:#0D6EFD;color:#fff;padding:10px 10px; text-decoration:none;border-radius:10px;">Join Meeting</a></p></div>';

    $subject = 'Alternative Appointment Confirmed!';
    $receiverEmail = $user['email'];

    emailSend($receiverEmail, $html, $subject);


    // Send mail to doctor

    $html = '<div style="font-size:1rem"><p>Hello Dr.' . $doctor['name'] . '!</p><p>' . $user['name'] . ' has booked an appointment with you on ' . date("d-m-Y", strtotime($date)) . ' at ' . $slot['time'] . '.</p><p>Thank you for accomodating them in your tight schedule. You can use the button below to start the appointment at the scheduled time.</p><p style="padding-top:20px"><a href="' . $result->start_url . '" style="background-color:#0D6EFD;color:#fff;padding:10px 10px; text-decoration:none;border-radius:10px;">Join Meeting</a></p></div>';

    $subject = 'Appointment has been Booked!';
    $receiverEmail = $doctor['email'];

    emailSend($receiverEmail, $html, $subject);

    if ($result1) {
        $_SESSION['success'] = 'check-email';
    } else {
        $_SESSION['failure'] = 'server-error';
    }

    header('Location: ../user-dashboard-appointment');
}
