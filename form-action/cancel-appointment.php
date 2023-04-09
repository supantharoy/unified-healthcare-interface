
<?php
date_default_timezone_set("Asia/Kolkata");
session_start();
require_once '../db/db.php';

$appointmentId = mysqli_real_escape_string($conn, $_POST['id']);

$sql = "UPDATE `appointment` SET `cancelled` = 1 WHERE `id` = '$appointmentId';";

if (mysqli_query($conn, $sql))
    echo json_encode("success");
