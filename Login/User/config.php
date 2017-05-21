<?php
$host = "localhost"; // Hostname
$port = "3306"; // MySQL Port : Default : 3306
$user = "$DBNAME"; // Username Here
$pass = "$DBPASS"; //Password Here
$db   = "$DBNAME"; // Database Name
$dbh  = new PDO('mysql:dbname='.$db.';host='.$host.';port='.$port,$user,$pass);
?>
