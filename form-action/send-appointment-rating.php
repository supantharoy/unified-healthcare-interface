
<?php
date_default_timezone_set("Asia/Kolkata");
session_start();
require_once '../db/db.php';

$id = mysqli_real_escape_string($conn, $_POST['id']);
$rating = mysqli_real_escape_string($conn, $_POST['rating']);

$sql = "UPDATE `appointment` SET `rating` = '$rating' WHERE `id` = '$id';";
$result = mysqli_query($conn, $sql);

$sql1 = "SELECT * FROM `appointment` WHERE `id` = '$id'";
$result1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_assoc($result1);

$sql2 = "SELECT * FROM `appointment` WHERE `doctor` = '" . $row1['doctor'] . "'";
$result2 = mysqli_query($conn, $sql2);

$sum = 0;
$c = 0;

while ($row2 = mysqli_fetch_assoc($result2)) {

    if ($row2['rating'] != 0) {
        $c++;
    }

    $sum = $sum + $row2['rating'];
}

$avgRating = $sum / $c;

$sql3 = "UPDATE `doctor-login` SET `ratings` = '$avgRating' WHERE `username` = '" . $row1['doctor'] . "'";
$result3 = mysqli_query($conn, $sql3);

if ($result3)
    echo json_encode("success");
