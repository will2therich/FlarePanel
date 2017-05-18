<!DOCTYPE html>
<html><head></head>
<body>
<?php
session_start();
if($_SESSION['gpx_username']==''){
 header("Location:login.php");
}else{
 include("config.php");
 $sql=$dbh->prepare("SELECT * FROM admins WHERE id=?");
 $sql->execute(array($_SESSION['user']));
 while($r=$sql->fetch()){
  echo "<center><h2>Hello, ".$r['username']."</h2>";
  echo "<a href='logout.php'>Log Out</a></center>";
 }
}
?>
</body>
</html>
