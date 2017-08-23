<?php
include("../../configuration.php");
$host = $settings['db_host']; // Hostname
$port = "3306"; // MySQL Port : Default : 3306
$user = $settings['db_username']; // Username Here
$pass = $settings['db_password']; //Password Here
$db   = $settings['db_name']; // Database Name
$dbh  = new PDO('mysql:dbname='.$db.';host='.$host.';port='.$port,$user,$pass);
?>
