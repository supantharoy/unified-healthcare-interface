
<?php

require_once '../db/db.php';

$type = mysqli_real_escape_string($conn, $_POST['type']);

if ($type == 'username') {

    $sql = "SELECT `username` FROM `user-login`";

    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $usernames[] = $row['username'];
    }

    echo json_encode($usernames);

} else if ($type == 'email') {

    $sql = "SELECT `email` FROM `user-login`";

    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $emails[] = $row['email'];
    }

    echo json_encode($emails);

} else if ($type == 'mobile') {

    $sql = "SELECT `mobile` FROM `user-login`";

    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $mobiles[] = $row['mobile'];
    }

    echo json_encode($mobiles);
    
} else {
    header("Location: ../user-signup");
    exit();
}
