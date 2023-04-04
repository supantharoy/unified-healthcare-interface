<?php

require_once '../db/db.php';

$username = mysqli_real_escape_string($conn, $_POST['username']);
$available = mysqli_real_escape_string($conn, $_POST['available']);


$sql = "UPDATE `doctor-login` SET `available` = $available WHERE `username` = '$username'";

if (mysqli_query($conn, $sql)) {
    echo json_encode("success");
}
