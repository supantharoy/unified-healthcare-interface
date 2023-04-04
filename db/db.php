<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "uhi";


$conn = mysqli_connect($servername, $username, $password, $database);

if (mysqli_connect_errno()){
    echo ("Sorry, we failed to connect: " . mysqli_connect_error());
    die();
}
