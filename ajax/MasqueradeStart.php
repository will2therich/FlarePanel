<?php
include('../configuration.php');
$servername = $settings['db_host'] ;
$username = $settings['db_username'];
$password = $settings['db_password'];
$dbname = $settings['db_name'];
include('../checkallowed.php');
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
if(isset($_REQUEST['somevar'])){
  $userid = $_POST['Userid'];
if($userid==0) {
  echo 'User ID not found';
}
$dbh  = $conn;
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
                              `id` = '$userid'
                            ORDER BY id ASC
                            LIMIT 1") or die('Sorry, we were unable to check this user.  Please try again soon.');

while($r = $result_login->fetch_array()){
$id =$r['id'];
 $lang=$r['language'];
 $usrname=$r['username'];
 $email2=$r['email_address'];
 $firstname =$r['first_name'];
 $prmftp =$r['perm_ftp'];
 $prmfiles =$r['perm_files'];
 $prmstart =$r['perm_startup'];
 $prmstartsee =$r['perm_startup_see'];
 $prmchpass =$r['perm_chpass'];
 $prmchupdetails =$r['perm_updetails'];
 session_start();
$_SESSION = array();
$_SESSION['gpx_userid']   = $id;
$_SESSION['user']=$id;
$_SESSION['gpx_lang']     = $lang;
$_SESSION['gpx_username'] = $usrname;
$_SESSION['MASK'] = 1;
$_SESSION['gpx_email']    = $email2;
$_SESSION['gpx_fname']    = $firstname;
$_SESSION['gpx_type']     = 'user';
$gpx_userid = $id;
$perms_arr['perm_ftp']         = $prmftp;
$perms_arr['perm_files']        = $prmfiles;
$perms_arr['perm_startup']      = $prmstart;
$perms_arr['perm_startup_see']  = $prmstartsee;
$perms_arr['perm_chpass']       = $prmchpass;
$perms_arr['perm_updetails']    = $prmchupdetails;
$_SESSION['gpx_perms']  = $perms_arr;
echo "Now Logged In As ".$usrname;
}







}
?>
