<?php
session_start();
if($_SESSION['user']!=''){
 header("Location:home.php");
}
?>
<!DOCTYPE html>
<html>
 <head></head>
 <body>
  <form action="register.php" method="POST">
   <label>E-Mail <input name="user" /></label><br/>
   <label>Password <input name="pass" type="password"/></label><br/>
   <button name="submit">Register</button>
  </form>
  <?php
  if(isset($_POST['submit'])){
   include("config.php");   
   if(isset($_POST['user']) && isset($_POST['pass'])){
    $password=$_POST['pass'];
    $sql=$dbh->prepare("SELECT COUNT(*) FROM `users` WHERE `username`=?");
    $sql->execute(array($_POST['user']));
    if($sql->fetchColumn()!=0){
    }else{
     function rand_string($length) {
      $str="";
      $chars = "subinsblogabcdefghijklmanopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
      $size = strlen($chars);
      for($i = 0;$i < $length;$i++) {
       $str .= $chars[rand(0,$size-1)];
      }
      return $str; /* http://subinsb.com/php-generate-random-string */
     }
     $p_salt = rand_string(20); /* http://subinsb.com/php-generate-random-string */
     $site_salt="subinsblogsalt"; /*Common Salt used for password storing on site.*/
     $salted_hash = hash('sha256', $password.$site_salt.$p_salt);
     $sql=$dbh->prepare("INSERT INTO `users` (`id`, `username`, `password`, `psalt`) VALUES (NULL, ?, ?, ?);");
     $sql->execute(array($_POST['user'], $salted_hash, $p_salt));
     echo "Successfully Registered.";
    }
   }
  }
  ?>
 </body>
</html>
