<?php
require('checkallowed.php'); // Check logged-in
#require('../configuration.php');

// Setup Language
require(DOCROOT.'/lang.php');

// Check Install
if(file_exists('../install')) die('Please delete the "install" directory before continuing!');

// Get system settings
require('../includes/classes/core.php');
$Core = new Core;
$Core->dbconnect();
$settings = $Core->getsettings();
$cfg_company    = $settings['company'];

// Setup plugins
require(DOCROOT.'/includes/classes/plugins.php');
$Plugins  = new Plugins;
$Plugins->setup_actions();

$Plugins->do_action('index_init'); // Plugins
?>
<!DOCTYPE html>
<html>
<head>
<!--
`::::-
-sssssssssssso: .ssss+                                                       `..ossssssss.
/sssssssssssss/ .ssss+                                                     .sNMMMMMMMMMMMM
/sssso-------.  .ssss+                                                     mMMMMdd/::::hdd
/sssso          .ssss+    `..:++++++:.`     -+++:./++++.   ../++++++-`    sNMMMM.                `:::::::``     `:::- .::::::::-       .::::.     -::::::.      -::::` -:::`  ``::::::::
/sssso```````   .ssss+    -ssssssssssso:    :ssssssssss- ./sssssssssso:`  -mMMMM+/``           //dMMMMMMMdh:   .mMMMmomMMMMNMMMd-     .yMMMm/  -/sNMMMMMMmo/.   hMMMMoyNMMM-`:hdMMMMMMMM`
/sssssooooooo/  .ssss+    -+/:....-ossso-   :sssss+/-:/..osss+....:osss:`  omMMMMMmd++.      `+MMMMssssyMMMN/  -MMMMMMMdhNy+NMMMy`   `oMMMNo `:hMMNhssssmMMMy.  hMMMMMNNymN.yMMMMysssssm`
/sssssooooooo+  .ssss+     ``.::::+sssss:   :ssss:     `+ssss/:::::ossss.   .oommMMMMMmo.    mMMMMy....-hMMMm  -MMMMMm+.`.``+MMMNo   /NMMNo` +NMMMs-....+mMMM/  hMMMMN/. .. dMMMMs..   .
/sssso````````  .ssss+    ./ossssooossss:   :ssss-     :osssssssssssssss.      `.+odMMMMms   MMMMMmmmmmmNMMMN+ -MMMMm/      .yMMMd/ -hMMMs`  oMMMMNmmmmmmNMMM/  hMMMM/      /dMMMMNmso-.
/sssso          .ssss+   :sss+--.``:ssss:   :ssss-      +ssss/----------`          `/dMMMMs  MMMMMdddddddddddy -MMMMh        :mMMMs`oMMMh-   oMMMMNdddddddddd:  hMMMM:       `/+ddMMMMNN-
/sssso          .ssss+  -ssss+`  `-ossss:   :ssss-      :ssss:.     `..   ---        :MMMMM  MMMMN:````````:`` -MMMMh         +MMMmdNMMN+    oMMMMy.```````-.   hMMMM:      -`  ``:/NMMMN`
/sssso          .ssss+  `:sssso++ossssss:   :ssss-       :ossss+++++oss.  dNNhhhh:yhhNMMMM:  :hMMMNhy:::/hhd   -MMMMh         `sMMMMMMm+     .yMMMMd+::::shm/   hMMMM:      dhh/::::NMMMM`
:++++/          `++++:   `-+ossso+:/ssso-   :ssso.        `:++osssss++-   sNMMMMMMMMMMMMh-    `hhMMMMMMMMMMm   -MMMMh          `oMMMMMs       .ohmMMMMMMMMMd-   hMMMM:      dMMMMMMMMMMh:
            `````  `````    `````             ``````       ...syyyyyy-..         .-yyyyys...    :yyyo           `.....`          `.+yyyyy/.`    .oyyy.      ..syyyyy-..



-->
<?php $Plugins->do_action('index_head'); // Plugins ?>
<title>Admin | <?php if(!empty($cfg_company)) echo $cfg_company; else echo 'GamePanelX'; ?></title>
<?php
// Theme - Set user's chosen theme
if(isset($_SESSION['gpx_theme'])) echo '<link rel="stylesheet" type="text/css" href="../themes/'.$_SESSION['gpx_theme'].'/index.css" />';
else echo '<link rel="stylesheet" type="text/css" href="../themes/default/index.css" />';
?>
<link rel="stylesheet" type="text/css" href="../themes/dd.css" />
<script type="text/javascript" src="../scripts/jquery.min.js"></script>
<script type="text/javascript" src="../scripts/jquery.simplemodal.min.js"></script>
<script type="text/javascript" src="../scripts/jquery.dd.js"></script>
<script type="text/javascript">var ajaxURL='../ajax/ajax.php';</script>
<script type="text/javascript" src="../scripts/gpxadmin.js"></script>
<script type="text/javascript" src="../scripts/base64.js"></script>
<script type="text/javascript" src="../scripts/jquery-ui.min.js"></script>
<script type="text/javascript" src="../scripts/jquery.form.js"></script>
<!-- <script type="text/javascript" src="../scripts/internal.min.js"></script> -->
<script type="text/javascript" src="../scripts/internal/cloud.js"></script>
<script type="text/javascript" src="../scripts/internal/files.js"></script>
<script type="text/javascript" src="../scripts/internal/servers.js"></script>
<script type="text/javascript" src="../scripts/internal/settings.js"></script>
<script type="text/javascript" src="../scripts/internal/templates.js"></script>
<script type="text/javascript" src="../scripts/internal/network.js"></script>
<script type="text/javascript" src="../scripts/internal/users.js"></script>
<script type="text/javascript" src="../scripts/internal/admins.js"></script>
<script type="text/javascript" src="../scripts/internal/games.js"></script>
<script type="text/javascript" src="../scripts/internal/plugins.js"></script>

<link href="../scripts/upload/fileuploader.css" rel="stylesheet" type="text/css">
<script src="../scripts/upload/fileuploader.js" type="text/javascript"></script>
<script type="text/javascript">
function createUploader(){
  var uploader = new qq.FileUploader({
      element: document.getElementById("file_up"),
      action: "../ajax/file_upload.php",
      debug: true
  });
}
</script>

<script type="text/javascript">
$(document).ready(function(){
    $('#leftpanel_setup').click(function(){
        $('#leftpanel_setup_items').slideToggle('fast');
    });
    $('#leftpanel_servers').click(function(){
        $('#leftpanel_servers_items').slideToggle('fast');
    });
    $('#leftpanel_users').click(function(){
        $('#leftpanel_users_items').slideToggle('fast');
    });
    $('#leftpanel_accounts').click(function(){
        $('#leftpanel_accounts_items').slideToggle('fast');
    });
    $('#leftpanel_network').click(function(){
        $('#leftpanel_network_items').slideToggle('fast');
    });

    // Confirm leaving since everything is ajaxy
    $(window).bind('beforeunload', function(){
        return 'Are you sure you want to leave?';
    });

    // Load default page
    setTimeout("mainpage('default','')", 200);
});
</script>
</head>

<body>
<?php $Plugins->do_action('index_body'); // Plugins ?>

<div id="modal" style="display:none;"></div>

<!-- <div id="panel_top">
    <div id="panel_top_imgdiv"><img src="../images/logo.png" border="0" /></div>
    <div id="panel_top_txtdiv"><?php echo $lang['welcome_msg']; ?>, <b><?php echo $_SESSION['gpx_username']; ?></b>! <a href="logout.php" class="links" style="font-size:9pt;">(<?php echo $lang['logout']; ?>)</a></div>
</div> -->

<section class="navigation">
  <div class="nav-container">
    <div class="brand">
      <a href="#!"><img style="margin-left: -450px;margin-top: 12px;" src="../images/logo.png" border="0" /></a>
    </div>
<nav>
  <div class="nav-mobile">
    <a id="nav-toggle" href="#!"><span></span></a>
  </div>
  <ul class="nav-list">
    <li onClick="javascript:mainpage('default','');"><a href="#!">Home</a></li>
    <li><a href="#!">Panel Settings/Game Setup</a>
      <ul class="nav-dropdown">
        <li  onClick="javascript:mainpage('settings','');"><a style="margin-right: -52px;" href="#!"><img src="../images/icons/medium/edit.png" width="18" height="18" /><?php echo $lang['settings']; ?></a></li>
        <li  onClick="javascript:mainpage('games','');"><a style="margin-right: -52px;" href="#!"><img src="../images/icons/medium/template.png" width="18" height="18" /><?php echo $lang['game_setups']; ?></a></li>
        <li  onClick="javascript:mainpage('cloudgames','');"><a style="margin-right: -52px;" href="#!"><img src="../images/icons/medium/cloud.png" width="18" height="18" /><?php echo $lang['cloud_games']; ?></a></li>
        <li  onClick="javascript:mainpage('plugins','');"><a style="margin-right: -52px;" href="#!"><img src="../images/icons/medium/plugins.png" width="18" height="18" /><?php echo $lang['plugins']; ?></a></li>

      </ul>
    </li>
    <li><a href="#!">Server Settings/Options</a>
      <ul class="nav-dropdown">
        <li onClick="javascript:mainpage('servers','');"><a style="margin-right: -25px;" href="#!"><img src="../images/icons/medium/servers.png" width="18" height="18" /><?php echo $lang['all_servers']; ?></a></li>
        <li onClick="javascript:mainpage('servers','g');"><a style="margin-right: -25px;" href="#!"><img src="../images/icons/medium/servers.png" width="18" height="18" /><?php echo $lang['game_servers']; ?></a></li>
        <li onClick="javascript:mainpage('servers','v');"><a style="margin-right: -25px;" href="#!"><img src="../images/icons/medium/servers.png" width="18" height="18" /><?php echo $lang['voice_servers']; ?></a></li>
        <li onClick="javascript:mainpage('serveradd','');"><a style="margin-right: -25px;" href="#!"><img src="../images/icons/medium/servers.png" width="18" height="18" /><?php echo $lang['create_server']; ?></a></li>
      </ul>
    </li>
    <li><a href="#!">Accounts</a>
    <ul class="nav-dropdown">
      <li onClick="javascript:mainpage('users','');"><a href="#!"><img src="../images/icons/medium/accounts.png" width="18" height="18" /><?php echo $lang['list_users']; ?></a></li>
      <li onClick="javascript:user_show_create();"><a href="#!"><img src="../images/icons/medium/accounts.png" width="18" height="18" /><?php echo $lang['add_user']; ?></a></li>
      <li onClick="javascript:mainpage('admins','');"><a href="#!"><img src="../images/icons/medium/accounts.png" width="18" height="18" /><?php echo $lang['list_admins']; ?></a></li>
      <li onClick="javascript:admin_show_create();"><a href="#!"><img src="../images/icons/medium/accounts.png" width="18" height="18" /><?php echo $lang['add_admin']; ?></a></li>

    </ul></li>
    <li><a href="#!">Network Settings</a>
    <ul class="nav-dropdown">
      <li onClick="javascript:mainpage('network','');"><a href="#!"><img src="../images/icons/medium/network.png" width="18" height="18" /><?php echo $lang['all_servers']; ?></a></li>
      <li onClick="javascript:mainpage('networkadd','');"><a href="#!"><img src="../images/icons/medium/network.png" width="18" height="18" /><?php echo $lang['create_network']; ?></a></li>
    </ul></li>
    <li><a href="#!"><?php echo $_SESSION['gpx_username']; ?></a>
    <ul class="nav-dropdown">
      <li onClick="javascript:mainpage('settings','');"><a href="#!"><img src="../images/icons/medium/edit.png" width="18" height="18" />My Settings</a></li>
      <li><a href="./logout.php"><img src="../images/icons/medium/accounts.png" width="18" height="18" />Logout</a></li>
    </ul></li>
  </ul>

</nav>
</div>
</section>



<script type="text/javascript">
(function($) {
$(function() {
  $('nav ul li > a:not(:only-child)').click(function(e) {
    $(this).siblings('.nav-dropdown').toggle();
    $('.nav-dropdown').not($(this).siblings()).hide();
    e.stopPropagation();
  });
  $('html').click(function() {
    $('.nav-dropdown').hide();
  });
  $('#nav-toggle').on('click', function() {
    this.classList.toggle('active');
  });
  $('#nav-toggle').click(function() {
$('nav ul').toggle();
});
});
})(jQuery);
</script>








</nav>

<style media="screen">
html{
  background-color: #3e3e3e;
}
/*nav li  :hover{
  background-color: aliceblue;
}
nav a:hover{
  background-color: aliceblue;
}*/

@charset "UTF-8";
nav {
float: right;
background-color: cornflowerblue;
}
nav ul {
list-style: none;
margin: 0;
padding: 0;
}
nav ul li {
float: left;
position: relative;
}
nav ul li a {
display: block;
padding: 0 20px;
line-height: 70px;
background-color: cornflowerblue;
color: white;
text-decoration: none;
}
nav ul li a:hover {
background-color: aliceblue;
color: #4B6985;
}
nav ul li a:not(:only-child):after {
padding-left: 4px;
content: ' ▾';
}
nav ul li ul li {
min-width: 190px;
}
nav ul li ul li a {
padding: 15px;
line-height: 20px;
}

.nav-dropdown {
position: absolute;
z-index: 1;
box-shadow: 0 3px 12px rgba(0, 0, 0, 0.15);
display: none;
}

.nav-mobile {
position: absolute;
top: 0;
right: 0;
background: cornflowerblue;
height: 70px;
width: 70px;
}

@media only screen and (max-width: 800px) {
.nav-mobile {
  display: block;
}

nav {
  width: 100%;
  padding: 70px 0 15px;
}
nav ul {
  display: none;
}
nav ul li {
  float: none;
}
nav ul li a {
  padding: 15px;
  line-height: 20px;
}
nav ul li ul li a {
  padding-left: 30px;
}

.nav-dropdown {
  position: static;
}

nav ul {
  display: none;
}

#nav-toggle {
  position: absolute;
  left: 18px;
  top: 22px;
  cursor: pointer;
  padding: 10px 35px 16px 0px;
}
#nav-toggle span,
#nav-toggle span:before,
#nav-toggle span:after {
  cursor: pointer;
  border-radius: 1px;
  height: 5px;
  width: 35px;
  background: #4B6985;
  position: absolute;
  display: block;
  content: '';
  transition: all 300ms ease-in-out;
}
#nav-toggle span:before {
  top: -10px;
}
#nav-toggle span:after {
  bottom: -10px;
}
#nav-toggle.active span {
  background-color: transparent;
}
#nav-toggle.active span:before, #nav-toggle.active span:after {
  top: 0;
}
#nav-toggle.active span:before {
  transform: rotate(45deg);
}
#nav-toggle.active span:after {
  transform: rotate(-45deg);
}
}
@media screen and (min-width: 800px) {
.nav-list {
  display: block !important;
}
}
.navigation {
height: 70px;
background: cornflowerblue;
}

.nav-container {
max-width: 1000px;
margin: 0 auto;
}

.brand {
position: absolute;
padding-left: 20px;
float: left;
line-height: 70px;
text-transform: uppercase;
}
.brand a,
.brand a:visited {
color: #4B6985;
text-decoration: none;
}

</style>




<!--
<div id="panel_enc" align="left">
<div id="panel_left" style="border-top-right-radius:6px;">
    <div id="leftpanel_setup" class="panel_left_menugroup" style="border-top-right-radius:6px;"><?php echo $lang['setup']; ?></div>
    <div id="leftpanel_setup_items">
        <div class="panel_left_menuitem" onClick="javascript:mainpage('default','');"><?php echo $lang['home']; ?></div>
        <div class="panel_left_menuitem" onClick="javascript:mainpage('settings','');"><img src="../images/icons/medium/edit.png" width="18" height="18" /><?php echo $lang['settings']; ?></div>
        <div class="panel_left_menuitem" onClick="javascript:mainpage('games','');"><img src="../images/icons/medium/template.png" width="18" height="18" /><?php echo $lang['game_setups']; ?></div>
        <div class="panel_left_menuitem" onClick="javascript:mainpage('cloudgames','');"><img src="../images/icons/medium/cloud.png" width="18" height="18" /><?php echo $lang['cloud_games']; ?></div>
        <div class="panel_left_menuitem" onClick="javascript:mainpage('plugins','');"><img src="../images/icons/medium/plugins.png" width="18" height="18" /><?php echo $lang['plugins']; ?></div>
    </div>

    <div id="leftpanel_servers" class="panel_left_menugroup"><?php echo $lang['servers']; ?></div>
    <div id="leftpanel_servers_items">
        <div class="panel_left_menuitem" onClick="javascript:mainpage('servers','');"><img src="../images/icons/medium/servers.png" width="18" height="18" /><?php echo $lang['all_servers']; ?></div>
        <div class="panel_left_menuitem" onClick="javascript:mainpage('servers','g');"><img src="../images/icons/medium/servers.png" width="18" height="18" /><?php echo $lang['game_servers']; ?></div>
        <div class="panel_left_menuitem" onClick="javascript:mainpage('servers','v');"><img src="../images/icons/medium/servers.png" width="18" height="18" /><?php echo $lang['voice_servers']; ?></div>
        <div class="panel_left_menuitem" style="margin-bottom:3px;" onClick="javascript:mainpage('serveradd','');"><img src="../images/icons/medium/servers.png" width="18" height="18" /><?php echo $lang['create_server']; ?></div>
    </div>

    <div id="leftpanel_accounts" class="panel_left_menugroup"><?php echo $lang['accounts']; ?></div>
    <div id="leftpanel_accounts_items">
        <div class="panel_left_menuitem" onClick="javascript:mainpage('users','');"><img src="../images/icons/medium/accounts.png" width="18" height="18" /><?php echo $lang['list_users']; ?></div>
        <div class="panel_left_menuitem" onClick="javascript:user_show_create();"><img src="../images/icons/medium/accounts.png" width="18" height="18" /><?php echo $lang['add_user']; ?></div>
        <div class="panel_left_menuitem" onClick="javascript:mainpage('admins','');"><img src="../images/icons/medium/accounts.png" width="18" height="18" /><?php echo $lang['list_admins']; ?></div>
        <div class="panel_left_menuitem" onClick="javascript:admin_show_create();"><img src="../images/icons/medium/accounts.png" width="18" height="18" /><?php echo $lang['add_admin']; ?></div>
    </div>

    <div id="leftpanel_network" class="panel_left_menugroup"><?php echo $lang['network']; ?></div>
    <div id="leftpanel_network_items">
        <div class="panel_left_menuitem" onClick="javascript:mainpage('network','');"><img src="../images/icons/medium/network.png" width="18" height="18" /><?php echo $lang['all_servers']; ?></div>
        <div class="panel_left_menuitem" onClick="javascript:mainpage('networkadd','');"><img src="../images/icons/medium/network.png" width="18" height="18" /><?php echo $lang['create_network']; ?></div>
    </div>
</div> -->

<div id="panel_center"></div>
</div>

<input type="hidden" id="lastrt" value="" />

<?php $Plugins->do_action('index_body_end'); // Plugins ?>

</body>
</html>
<?php $Plugins->do_action('index_end'); // Plugins ?>
