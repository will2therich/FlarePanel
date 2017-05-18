<!DOCTYPE html>
<html><head>
<title>MySQL injection free Secure Login System - PHP Demo</title>
</head><body>
<div id="content" style="margin-top:10px;height:60%;">
<h2><u>MySQL injection free Secure Login System - PHP Demo</u></h2><br/>
<form method="POST" action="index.php" style="border:1px solid black;display:table;margin:0px auto;padding-left:10px;padding-bottom:5px;">
<table width="300" cellpadding="4" cellspacing="1">

<tr><td><td colspan="3"><strong>User Login</strong></td></tr>

<tr><td width="78">E-Mail</td><td width="6">:</td><td width="294"><input size="25" name="mail" type="text"></td></tr>

<tr><td>Password</td><td>:</td><td><input name="pass" size="25" type="password"></td></tr>

<tr><td></td><td></td><td><input type="submit" name="Submit" value="Login"></td>
</tr>
</table>
Login System provided by <a target="_blank" href='http://www.subinsb.com/2013/08/secure-injection-free-login-system-php.html'>Subins</a>
<?php
session_start();
//require('../configuration.php'); // No direct access
$conn = mysqli_connect("localhost","root","flareservers","gamepaneltest");
if($_SESSION['user']!=''){header("Location:home.php");}
include("../../configuration.php");
include("config.php");
$email=$_POST['mail'];
$password=$_POST['pass'];
if(isset($_POST) && $email!='' && $password!=''){
  $updatedcheck = mysqli_query($conn,"SELECT
    setpass_3010
    FROM users
    WHERE `username` = '$email'
    ") or die ("Unable To Check Login Try Again Later");
    $updatedpass = $updatedcheck->fetch_array();
  //  echo  '<h1>'.$updatedpass.'<h1>';
    $updated = $updatedpass['setpass_3010'];
  //  echo  $updated;
    $enc_key = $settings['enc_key'];

    if (isset($_POST) && $updated == 0) {
      echo "UPDATING";
      //$url_pass_oldstyle	= md5($password);
      $result_login = mysqli_query($conn, "SELECT
                                    id,
                                    perm_ftp,
                                    perm_files,
                                    perm_startup,
                                    perm_startup_see,
                                    perm_chpass,
                                    perm_updetails,
                                    theme,
                                    language,
                                    email_address,
                                    first_name
                                  FROM users
                                  WHERE
                                    `username` = '$email'
                                    AND AES_DECRYPT(sso_pass, '$enc_key') = '$password'
                                    AND `deleted` = '0'
                                  ORDER BY id ASC
                                  LIMIT 1") or die('Sorry, we were unable to check your login.  Please try again soon.');
      $totals = $result_login->num_rows;
      if($totals == 0) die('INVALID LOGIN');
      echo "Logged in";
      function rand_string($length) {
        $str="";
        $chars = "subinsblogabcdefghijklmanopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $size = strlen($chars);
        for($i = 0;$i < $length;$i++) {
          $str .= $chars[rand(0,$size-1)];
        }
        return $str; /* http://subinsb.com/php-generate-random-string */
      }
      echo "Updating Password to new measures";
      $site_salt="subinsblogsalt"; /*Common Salt used for password storing on site. You can't change it. If you want to change it, change it when you register a user.*/
      $p_salt = rand_string(20);
      $upd_pass = hash('sha256',$password.$site_salt.$p_salt);
      mysqli_query($conn, "UPDATE users SET `setpass_3010` = '1',`password` = '$upd_pass',`p_salt` = '$p_salt' WHERE username = '$email' ") or die('Failed to update password security: '.$GLOBALS['mysqli']->error);
      echo "<h2>For Security reasons your password has been updated please try again.</h2>";
    }
elseif (isset($_POST) && $updated != 0){
 $sql=$dbh->prepare("SELECT * FROM users WHERE username='$email'");
 $sql->execute(array($email));
 while($r=$sql->fetch()){
  $p=$r['password'];
  $p_salt=$r['p_salt'];
  $id=$r['id'];
  $lang=$r['language'];
  $usrname=$r['username'];
  $email=$r['email_address'];
  $firstname =$r['first_name'];
  $prmftp =$r['perm_ftp'];
  $prmfiles =$r['perm_files'];
  $prmstart =$r['perm_startup'];
  $prmstartsee =$r['perm_startup_see'];
  $prmchpass =$r['perm_chpass'];
  $prmchupdetails =$r['perm_updetails'];
 }
 $site_salt="subinsblogsalt"; /*Common Salt used for password storing on site. You can't change it. If you want to change it, change it when you register a user.*/
 $salted_hash = hash('sha256',$password.$site_salt.$p_salt);
 if($p==$salted_hash){
   // Check login
       // Store in session
       $_SESSION['gpx_userid']   = $id;
       $_SESSION['gpx_lang']     = $lang;
       $_SESSION['gpx_username'] = $usrname;
       $_SESSION['gpx_email']    = $email;
       $_SESSION['gpx_fname']    = $firstname;
       $_SESSION['gpx_type']     = 'user';

       $perms_arr['perm_ftp']         = $prmftp;
      $perms_arr['perm_files']        = $prmfiles;
      $perms_arr['perm_startup']      = $prmstart;
      $perms_arr['perm_startup_see']  = $prmstartsee;
      $perms_arr['perm_chpass']       = $prmchpass;
      $perms_arr['perm_updetails']    = $prmchupdetails;
  $_SESSION['gpx_perms']  = $perms_arr;
  header("Location:../../index.php");
}
  }
  else
  {
    echo "<h2>Username/Password is Incorrect.</h2>";
  }
}
?>
</form>
<!-- http://www.subinsb.com/2013/08/secure-injection-free-login-system-php.html -->
</div>
</body></html>
