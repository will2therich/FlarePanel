<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION['gpx_userid']) || !isset($_SESSION['gpx_admin'])) die('Please login');

$Plugins->do_action('home_top'); // Plugins

// Debug info
if(GPXDEBUG)
{
    // Get version
    $result_vr    = $GLOBALS['mysqli']->query("SELECT config_value FROM configuration WHERE config_setting = 'version' LIMIT 1");
    $row_vr       = $result_vr->fetch_row();
    $gpx_version  = $row_vr[0];

    echo '<b>NOTICE:</b> Debug mode has been enabled in configuration.php.<br />';
    echo 'DEBUG: Master Version '.$gpx_version.'<br />';
    echo 'DEBUG: Document Root: '.DOCROOT.'<br />';
    if($GLOBALS['mysqli']->error) echo 'DEBUG: Last MySQL error: '.$GLOBALS['mysqli']->error.'<br />';
}
?>
<!--


                                                                                    ``.```````````````````````````````````````````````````.``
                                                                                    :y+yyhyhhhhhhhhhhyhhhhhyhhhhhhhhyhhhhhhhhhyhhhhhhhhhyy+y+`
                                                                                    /dydhyddsdmyhmhymdsddsdmyhmy/::/+sshmyymhymdsdmyhmhymdydo`
                                                                                    /ddmhhdd+dmoymsomh+dd+hmosd-`` ```+hmssmh+md+dmoymsomddmo`
                                                                                    /mdmmmdd+dmoymyomh+dd+hmoo-``.`` `+hmssmy+md+dmoymsomdmdo`
                                                                                    /mmdmmmd+dmoymyomh+dd+hm+` `:+``` +hmssmh+md+dmoymsommmmo`
                                                                                    /ddmmmmdodmoymysmhoddohs```/o+ ```ohmssmhomdodmoymssmmddo``
                          `.-::-`                                                   /d+dddddddmddmdddddddd+```sdd+  ``dmdddmdddmddmddddddd+do``   ```     `.  `.
                          :/`  .-    ````` ` ` `````    ``   ````` ` ` ``` `````    :hhdddddddhdddddddddh:```sddd/ ```dhddddddhdhdddddhdddhd+`    :s+     :/  :/
                        ` +:```     :::::/`` o:-:-./    +.  :::::/`` o:-:-`+:::-    /dodddmdhddhdmdhddhd: `.sdmdh+  ``hdmddddhddhdmhdmdddd+do``  .s`+:    :/  :/
                           .::::.  .o````-/  y`    +-  :/  .o````-/  y`  `.o.       /ddmysdd+hmoymsomh/. `.hosmyo+    +ymsomy+md+dmoymsomdmmo`   s.``s`   :/  :/
                               `o- :o-----.  s     `s`.o   -o-----.  s    ``-::/`   /ddmdmdd+dmoymsoms````ymosmyo+ `  +ymssmh+md+dmoymsomdmdo`  ++:::/s`  :/  :/
                          --`  .o. `+-`  .`  s `    .oo`   `+-`  .`  s    `. ``o.   /dddddmd+dmoymsos` `-+hmosmyo+ `` +ymssmh+md+dmoymsommmdo``:+`` ` :+  :/  :/
                         ``.:::-``  `.:::-` `.`      -.     `.:::-` `.`  ``-:::`    /mmmmddd+dmoyms:```:d+hmosmyo+`` `+ymssmh+md+dmoymsommddo``/`      /` .-  .-
                                ` `          `                       `              /dsdddmdhdmhdms````+o/+o++o++:` ``/+:`omdhddhdmhdmdhmdsdo` `
                                                                                    :hyddddddddddd+```   ``` `````````````odddddddddddddhdyd+`
                                                                                    /d+dddddddddddh:-------------.`` `---:dmdddddddddddddd+do`
                                                                                    /mdmyyddodmoymyodh+dd+hdosdy++ `` +ydssmhomdodmoymysmmdmo`
                                                                                    /ddmdddd+dmoymyomh+dd+hmosmyo+``` +hmssmh+md+dmoymsomdmdo
                                                                                    /dmmdmmd+dmoymyomh+dd+hm/-/:.- `` -://smy+dd+dmoymsomdmdo
                                                                                    /ddmmmmd+dmoymyomh+dd+hm.```````` ` ``omhomd+dmoymsomdmdo`
                                                                                    /dhdmmddsdmyhmhymdsddsdms+o++oo++o++ooymhsddsdmyhmhymmhmo`
                                                                                    :h+hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh+h+`
                                                                                    `...----................................................``





-->
<div class="infobox" style="display:none;"></div>

<div class="" style="margin-top: 21px;text-align: center;border: 1px solid green;background: darkgreen;border-radius: 101px;margin-left: 493px;width: 100%;color:white;">
  <div class="checkmark-circle">
  <div class="background"></div>
  <div class="checkmark draw"></div>
</div>
<p>FlarePanel Seems to be working correctly</p>
</div>


<div class="container" style="color:white !important;font-size:15px;margin-top: 5%;">

  <header>
    <div class="fa fa-gear"></div>
    <div class="title">Admin Dash - Quick Links</div>
  </header>

  <div class="content-wrapper" style="width:76%">

  </div>

<div id="homeic_boxes" style="width: 100%;">
    <div class="homeic_box" onClick="javascript:mainpage('servers','');">
        <img src="../images/icons/medium/servers.png" /><?php echo $lang['servers']; ?>
    </div>
    <div class="homeic_box" onClick="javascript:mainpage('users','');">
        <img src="../images/icons/medium/accounts.png" /><?php echo $lang['accounts']; ?>
    </div>
    <div class="homeic_box" onClick="javascript:mainpage('games','');">
        <img src="../images/icons/medium/template.png" /><?php echo $lang['game_setups']; ?>
    </div>
    <div class="homeic_box" onClick="javascript:mainpage('settings','');">
        <img src="../images/icons/medium/edit.png" /><?php echo $lang['settings']; ?>
    </div>


    <div class="homeic_box" onClick="javascript:mainpage('cloudgames','');">
        <img src="../images/icons/medium/cloud.png" /><?php echo $lang['cloud_games']; ?>
    </div>
    <div class="homeic_box" onClick="javascript:mainpage('network','');">
        <img src="../images/icons/medium/network.png" /><?php echo $lang['network']; ?>
    </div>
    <div class="homeic_box" onClick="javascript:mainpage('plugins','');">
        <img src="../images/icons/medium/plugins.png" /><?php echo $lang['plugins']; ?>
    </div>
    <div class="homeic_box" onClick="javascript:mainpage('admins','');">
        <img src="../images/icons/medium/accounts.png" /><?php echo $lang['admins']; ?>
    </div>
	<div class="homeic_box" onClick="javascript:mainpage('subusers','');">
        <img src="../images/icons/medium/accounts.png" /><?php echo 'Sub-users'?>
    </div>
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
height: 29rem;
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

.checkmark-circle {
  width: 150px;
  height: 150px;
  position: relative;
  display: inline-block;
  vertical-align: top;
}
.checkmark-circle .background {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  background: #2EB150;
  position: absolute;
}
.checkmark-circle .checkmark {
  border-radius: 5px;
}
.checkmark-circle .checkmark.draw:after {
  -webkit-animation-delay: 100ms;
  -moz-animation-delay: 100ms;
  animation-delay: 100ms;
  -webkit-animation-duration: 1s;
  -moz-animation-duration: 1s;
  animation-duration: 1s;
  -webkit-animation-timing-function: ease;
  -moz-animation-timing-function: ease;
  animation-timing-function: ease;
  -webkit-animation-name: checkmark;
  -moz-animation-name: checkmark;
  animation-name: checkmark;
  -webkit-transform: scaleX(-1) rotate(135deg);
  -moz-transform: scaleX(-1) rotate(135deg);
  -ms-transform: scaleX(-1) rotate(135deg);
  -o-transform: scaleX(-1) rotate(135deg);
  transform: scaleX(-1) rotate(135deg);
  -webkit-animation-fill-mode: forwards;
  -moz-animation-fill-mode: forwards;
  animation-fill-mode: forwards;
}
.checkmark-circle .checkmark:after {
  opacity: 1;
  height: 75px;
  width: 37.5px;
  -webkit-transform-origin: left top;
  -moz-transform-origin: left top;
  -ms-transform-origin: left top;
  -o-transform-origin: left top;
  transform-origin: left top;
  border-right: 15px solid white;
  border-top: 15px solid white;
  border-radius: 2.5px !important;
  content: '';
  left: 25px;
  top: 75px;
  position: absolute;
}

@-webkit-keyframes checkmark {
  0% {
    height: 0;
    width: 0;
    opacity: 1;
  }
  20% {
    height: 0;
    width: 37.5px;
    opacity: 1;
  }
  40% {
    height: 75px;
    width: 37.5px;
    opacity: 1;
  }
  100% {
    height: 75px;
    width: 37.5px;
    opacity: 1;
  }
}
@-moz-keyframes checkmark {
  0% {
    height: 0;
    width: 0;
    opacity: 1;
  }
  20% {
    height: 0;
    width: 37.5px;
    opacity: 1;
  }
  40% {
    height: 75px;
    width: 37.5px;
    opacity: 1;
  }
  100% {
    height: 75px;
    width: 37.5px;
    opacity: 1;
  }
}
@keyframes checkmark {
  0% {
    height: 0;
    width: 0;
    opacity: 1;
  }
  20% {
    height: 0;
    width: 37.5px;
    opacity: 1;
  }
  40% {
    height: 75px;
    width: 37.5px;
    opacity: 1;
  }
  100% {
    height: 75px;
    width: 37.5px;
    opacity: 1;
  }
}

</style>






<?php
//
// Check how setup they are
//
$result_tpl = $GLOBALS['mysqli']->query("SELECT
                              u.id AS uid,
                              s.id AS sid,
                              t.id AS tid,
                              n.id AS nid
                            FROM configuration AS c
                            LEFT JOIN users AS u ON (SELECT id FROM users LIMIT 1)
                            LEFT JOIN servers AS s ON (SELECT id FROM servers LIMIT 1)
                            LEFT JOIN templates AS t ON (SELECT id FROM templates WHERE t.status = 'complete' LIMIT 1)
                            LEFT JOIN network AS n ON (SELECT id FROM network LIMIT 1)
                            LIMIT 1") or die('Failed to check setup: '.$GLOBALS['mysqli']->error);

$row_tpl  = $result_tpl->fetch_row();
$ck_u   = $row_tpl[0];
$ck_s   = $row_tpl[1];
$ck_t   = $row_tpl[2];
$ck_n   = $row_tpl[3];

// Network
if(empty($ck_n)) echo '<b>'.$lang['def_adm_tip_docs'].':</b> <a class="links" href="http://gamepanelx.com/wikiv3/index.php?title=Master_Install" target="_blank">'.$lang['documentation'].'</a><br /><br />
<div class="def_warnings">'.$lang['def_adm_step'].' 1.) <b>'.$lang['network'].': </b> '.$lang['def_adm_tip_net'].': <span class="links" style="font-size:9pt;" onClick="javascript:mainpage(\'networkadd\',\'\');">'.$lang['click_here'].'</span></div>';

// User Accounts
if(empty($ck_u)) echo '<div class="def_warnings">'.$lang['def_adm_step'].' 2.) <b>'.$lang['accounts'].': </b> '.$lang['def_adm_tip_accts'].' (<span class="links" style="font-size:9pt;" onClick="javascript:user_show_create();">'.$lang['click_here'].'</span>)</div>';

// Templates
if(empty($ck_t)) echo '<div class="def_warnings">'.$lang['def_adm_step'].' 3.) <b>'.$lang['templates'].': </b> '.$lang['def_adm_tip_tpl'].' (<span class="links" style="font-size:9pt;" onClick="javascript:mainpage(\'games\',\'\');">'.$lang['click_here'].'</span>)</div>';

// Templates and Users, no servers yet
if($ck_t && $ck_u && !$ck_s) echo '<div class="def_warnings" style="color:#444;"><b style="color:green;">'.$lang['servers'].': </b>'.$lang['def_adm_tip_srv1'].' <span class="links" style="font-size:9pt;" onClick="javascript:server_show_create();">'.$lang['click_here'].'</span></div>';

// Servers
elseif(empty($ck_s)) echo '<div class="def_warnings">'.$lang['def_adm_step'].' 4.) <b>'.$lang['servers'].': </b> '.$lang['def_adm_tip_srv2'].'</div>';

##########################

$Plugins->do_action('home_bottom'); // Plugins

?>
