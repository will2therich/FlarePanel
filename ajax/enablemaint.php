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
echo "Maintinence Mode Enabled successfully";
mysqli_query($conn , "UPDATE configuration SET config_value = '1' WHERE config_setting = 'maint_mode' ");

?>
