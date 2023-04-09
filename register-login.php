<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "register-login";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("خطایی رخ داده است!;");
}

?>