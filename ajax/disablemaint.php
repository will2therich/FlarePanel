<?php
$servername = "localhost";
$username = "root";
$password = "flareservers";
$dbname = "gamepaneltest";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Maintinence Mode Disabled successfully";
mysqli_query($conn , "UPDATE configuration SET config_value = '0' WHERE config_setting = 'maint_mode' ");

?>
