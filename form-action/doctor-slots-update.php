<?php 

require_once '../db/db.php';

$username = mysqli_real_escape_string($conn, $_POST['username']);
$checked = array_values(json_decode(stripslashes(mysqli_real_escape_string($conn, $_POST['checked'])), true));
$unchecked = array_values(json_decode(stripslashes(mysqli_real_escape_string($conn, $_POST['unchecked'])), true));


for ($i = 0; $i < count($checked); $i++) {
    $sql1 = "UPDATE `doctor-availability` SET $checked[$i] =1 WHERE `username` = '$username'";
    mysqli_query($conn, $sql1);
}

for ($i = 0; $i < count($unchecked); $i++) {
    $sql2 = "UPDATE `doctor-availability` SET $unchecked[$i] =0 WHERE `username` = '$username'";
    mysqli_query($conn, $sql2);
}

if (count($unchecked) == 18 && count($checked) == 0){
    $sql = "UPDATE `doctor-login` SET `available` = 0 WHERE `username` = '$username'";
} else {
    $sql = "UPDATE `doctor-login` SET `available` = 1 WHERE `username` = '$username'";
}

if (mysqli_query($conn, $sql)){
    echo json_encode("success");
}
