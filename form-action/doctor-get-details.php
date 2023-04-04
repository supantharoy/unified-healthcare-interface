
<?php

require_once '../db/db.php';

$type = mysqli_real_escape_string($conn, $_POST['type']);

if ($type == 'username') {

    $sql = "SELECT `username` FROM `doctor-login`";

    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $usernames[] = $row['username'];
    }

    echo json_encode($usernames);
} else if ($type == 'email') {

    $sql = "SELECT `email` FROM `doctor-login`";

    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $emails[] = $row['email'];
    }

    echo json_encode($emails);
} else if ($type == 'mobile') {

    $sql = "SELECT `mobile` FROM `doctor-login`";

    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $mobiles[] = $row['mobile'];
    }

    echo json_encode($mobiles);
} else if ($type == 'field') {

    $field = mysqli_real_escape_string($conn, $_POST['field']);

    $sql = "SELECT `username` FROM `doctor-login` WHERE `specialization` = '" . $field . "'";

    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $usernames[] = $row['username'];
    }

    echo json_encode($usernames);
} else {
    header("Location: ../user-signup");
    exit();
}
