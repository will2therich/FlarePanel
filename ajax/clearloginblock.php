<?php
include('../configuration.php');
$servername = $settings['db_host'] ;
$username = $settings['db_username'];
$password = $settings['db_password'];
$dbname = $settings['db_name'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if(isset($_REQUEST['somevar'])){
  $id = $_POST['id'];
   mysqli_query($conn , "UPDATE users SET login_attempts = '0' WHERE id = '$id' ");
echo "Updated Sucessfully";
}

?>
