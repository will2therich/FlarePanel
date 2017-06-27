<?php
require('checkallowed.php'); // Check logged-in
?>

<!-- <div class="page_title">
    <div class="page_title_icon"><img src="../images/icons/medium/edit.png" border="0" /></div>
    <div class="page_title_text"><?php echo $lang['settings']; ?></div>
</div> -->
<div class="" style="display: table;margin-left: 692px;margin-top: 10px;text-align: center;">

<div class="infobox" style="display:none;" ></div>
</div>

<?php
// Get all control panel settings
if(!$Core)
{
    require('includes/classes/core.php');
    $Core = new Core;
}
$Core->dbconnect();
$settings = $Core->getsettings();

$cfg_email        = $settings['default_email_address'];
$cfg_lang         = $settings['language'];
$cfg_company      = $settings['company'];
$cfg_theme        = $settings['theme'];
$cfg_api_key      = $settings['api_key'];
$cfg_version      = $settings['version'];
$cfg_steam_user   = $settings['steam_login_user'];
$cfg_steam_pass   = $settings['steam_login_pass'];
$cfg_steam_auth   = $settings['steam_auth'];
$cfg_steam_user=substr($cfg_steam_user, 6);$cfg_steam_user=substr($cfg_steam_user, 0, -6);$cfg_steam_user=base64_decode($cfg_steam_user);
$cfg_steam_pass=substr($cfg_steam_pass, 6);$cfg_steam_pass=substr($cfg_steam_pass, 0, -6);$cfg_steam_pass=base64_decode($cfg_steam_pass);


$Plugins->do_action('settings_top'); // Plugins
?>

<div class="container" style="color:white !important;font-size:15px;margin-top: auto;">

  <header>
    <div class="fa fa-gear"></div>
    <div class="title">Admin Dash - User Settings</div>
  </header>

  <div class="content-wrapper" style="width:76%">

  </div>


<table border="0"  style="margin-left: 361px;" cellpadding="2" cellspacing="0" width="600" class="cfg_table">
<tr>
  <td width="200"><b><?php echo $lang['version']; ?>:</b></td>
  <td><b><?php echo $cfg_version; ?></b></td>
</tr>

<tr>
  <td colspan="2">&nbsp;</td>
</tr>

<tr>
  <td><b><?php echo $lang['default_language']; ?>:</b></td>
  <td>
    <select id="lang" class="dropdown">
      <?php
      // List everything in the 'languages/' dir
      if ($handle = opendir(DOCROOT.'/languages'))
      {
          while(false !== ($entry = readdir($handle)))
          {
              // Loop over PHP language files
              if(preg_match('/\.php$/i', $entry) && $entry != 'index.php')
              {
                  $cur_item = str_replace('.php', '', $entry);

                  if($cur_item == $cfg_lang) echo '<option value="'.$cur_item.'" selected>'.ucwords($cur_item).'</option>';
                  elseif(empty($cfg_lang) && $cur_item == 'english')  echo '<option value="english" selected>English</option>';
                  else                      echo '<option value="'.$cur_item.'">'.ucwords($cur_item).'</option>';

                  // Default to english
                  #if($opt_val == 'english') echo '<option value="english" selected>English</option>';
                  #else echo '<option value="'.$opt_val.'">'.ucwords($opt_val).'</option>';
              }
          }

          closedir($handle);
      }
      ?>
    </select>
  </td>
</tr>
<tr>
  <td><b><?php echo $lang['theme']; ?>:</b></td>
  <td>
    <select id="theme" class="dropdown">
      <?php
      // List everything in the 'themes/' dir
      if ($handle = opendir(DOCROOT.'/themes'))
      {
          while(false !== ($entry = readdir($handle)))
          {
              // Loop over themes
              if($entry != 'index.php' && !preg_match('/^\./', $entry) && !preg_match('/\.css$/i', $entry))
              {
                  if($cfg_theme == $entry) echo '<option value="'.$entry.'" selected>'.ucwords($entry).'</option>';
                  else echo '<option value="'.$entry.'">'.ucwords($entry).'</option>';
              }
          }

          closedir($handle);
      }
      ?>
    </select>
  </td>
</tr>

<tr>
  <td><b><?php echo $lang['email_address']; ?>:</b></td>
  <td><input type="text" id="email" value="<?php echo $cfg_email; ?>" class="inputs" /></td>
</tr>
<tr>
  <td><b><?php echo $lang['company']; ?>:</b></td>
  <td><input type="text" id="company" value="<?php echo $cfg_company; ?>" class="inputs" /></td>
</tr>
<tr>
  <td><b><?php echo $lang['api_key']; ?>:</b></td>
  <td><input type="text" id="api_key" value="<?php echo $cfg_api_key; ?>" class="inputs" readonly /></td>
</tr>
<tr>
  <td colspan="2">&nbsp;</td>
</tr>

<tr>
  <td><b>Steam Login User:</b></td>
  <td><input type="text" id="steam_user" value="<?php echo $cfg_steam_user; ?>" class="inputs" /></td>
</tr>
<tr>
  <td><b>Steam Login Password:</b></td>
  <td><input type="password" id="steam_pass" value="<?php echo $cfg_steam_pass; ?>" class="inputs" /></td>
</tr>
<tr>
  <td><b>Steam Auth Code:</b></td>
  <td><input type="text" id="steam_auth" value="<?php echo $cfg_steam_auth; ?>" class="inputs" /></td>
</tr>

<?php $Plugins->do_action('settings_table'); // Plugins ?>
</table>

<div align="center">
  <div class='btn' style="margin-top: 229px;">
    <spam class="" onClick="javascript:settings_save();"><?php echo $lang['save']; ?></span>
  <div>
</div>

<style media="screen">
html{
  background-color: #3e3e3e;
}
.container {
position: absolute;
top: 50%;
left: 50%;
-webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
width: 72rem;
height: 33rem;
background: #3e3e3e;
box-shadow: 0 30px 20px -20px rgba(0, 0, 0, 0.3);
box-sizing: border-box;
}
header {
width: 100%;
height: 3rem;
padding-left: 2rem;
background: -webkit-linear-gradient(45deg, #FF512F, #DD2476);
background: linear-gradient(45deg, #FF512F, #DD2476);
background-size: 300% 300%;
color: #fff;
clear: both;
box-sizing: border-box;
-webkit-animation: coolgrad 6s ease infinite;
        animation: coolgrad 6s ease infinite;
}
header .fa {
font-size: 1.4rem;
height: 3rem;
line-height: 3rem;
float: left;
-webkit-animation: spin 4s ease infinite;
        animation: spin 4s ease infinite;
}
header .title {
position: relative;
height: 3rem;
line-height: 3rem;
font-weight: bold;
float: right;
padding: 0 2rem 0 1rem;
background: rgba(17, 17, 17, 0.35);
}
header .title:after {
content: "";
position: absolute;
right: 100%;
width: 0;
height: 0;
border-left: 1rem solid transparent;
border-bottom: 3rem solid rgba(17, 17, 17, 0.2);
}
header .title:before {
content: "";
position: absolute;
right: 100%;
width: 0;
height: 0;
border-left: 1rem solid transparent;
border-bottom: 3rem solid rgba(25, 25, 25, 0.2);
border-right: 2rem solid rgba(25, 25, 25, 0.2);
}
.content-wrapper {
width: 50%;
position: absolute;
top: 50%;
left: 50%;
-webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
top: calc(54%);
}
.content-wrapper .section {
position: relative;
height: 2rem;
margin-bottom: 1rem;
clear: both;
}
.content-wrapper .section label {
float: left;
height: 2rem;
line-height: 2rem;
}
.content-wrapper .section input[type="checkbox"],
.content-wrapper .section select {
float: right;
}
.content-wrapper .section input[type="checkbox"] {
display: none;
}
.content-wrapper .section input[type="checkbox"] {
display: inline-block;
width: 1.2rem;
height: 2rem;
vertical-align: middle;
background: red;
cursor: pointer;
}
.content-wrapper .section select {
height: 2rem;
padding: 0 1rem;
border-radius: 4px;
box-sizing: border-box;
}
@-webkit-keyframes spin {
from {
  -webkit-transform: rotate(0deg);
          transform: rotate(0deg);
}
to {
  -webkit-transform: rotate(360deg);
          transform: rotate(360deg);
}
}
@keyframes spin {
from {
  -webkit-transform: rotate(0deg);
          transform: rotate(0deg);
}
to {
  -webkit-transform: rotate(360deg);
          transform: rotate(360deg);
}
}
@-webkit-keyframes coolgrad {
0% {
  background-position: 0% 75%;
}
50% {
  background-position: 100% 26%;
}
100% {
  background-position: 0% 75%;
}
}
@keyframes coolgrad {
0% {
  background-position: 0% 75%;
}
50% {
  background-position: 100% 26%;
}
100% {
  background-position: 0% 75%;
}
}


@import url(http://fonts.googleapis.com/css?family=Roboto);


.btn {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate3d(-50%, -50%, 0);
  padding: 1em 2em;
  background-color: #3498db;
  border-radius: 3px;
  color: #fff;
  font-family: 'Roboto', sans-serif;
  cursor: pointer;
  overflow: hidden;
  box-shadow: 0 2px 0 #2980b9;
}
.btn span {
  position: relative;
  z-index: 1;
}
.btn .circle {
  position: absolute;
  z-index: 0;
  background-color: #2980b9;
  border-radius: 50%;
  transform: scale(0);
  opacity: 1;
  width: 100px;
  height: 100px;
}
.btn .circle.animate {
  animation: grow .5s linear;
}

@keyframes grow {
  to {
    transform: scale(2.5);
    opacity: 0;
  }
}



</style>
<script type="text/javascript">
(function() {
var material;

$(document).ready(function() {
  return material.init();
});

material = {
  init: function() {
    return this.bind_events();
  },
  bind_events: function() {
    return $(document).on("click", ".btn", function(e) {
      var circle, size, x, y;
      e.preventDefault();
      circle = $("<div class='circle'></div>");
      $(this).append(circle);
      x = e.pageX - $(this).offset().left - circle.width() / 2;
      y = e.pageY - $(this).offset().top - circle.height() / 2;
      size = $(this).width();
      circle.css({
        top: y + 'px',
        left: x + 'px',
        width: size + 'px',
        height: size + 'px'
      }).addClass("animate");
      return setTimeout(function() {
        return circle.remove();
      }, 500);
    });
  }
};

}).call(this);

</script>
