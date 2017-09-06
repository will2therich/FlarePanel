<?php
require('checkallowed.php'); // Check logged-in
?>
<div class="container" style="color:white !important;font-size:15px;margin-top: 5%;">

    <header>
        <div class="fa fa-gear"></div>
        <div class="title">Admin Dash - Servers</div>
    </header>

<?php $Plugins->do_action('servers_top'); // Plugins ?>

<!--<div class="box">-->
<!--<div class="box_title" id="box_servers_title">--><?php //echo $lang['servers']; ?><!--</div>-->
<!--<div class="box_content" id="box_servers_content">-->
<!--</div>-->
<!--</div>-->

<table table border="0"  style="margin-left: 70px;width: 85%;" cellpadding="2" cellspacing="0" width="600" class="cfg_table">
  <tr>
    <td width="25">&nbsp;</td>
    <td width="410"><b><?php echo $lang['game']; ?></b></td>
    <td width="210"><b><?php echo $lang['username']; ?></b></td>
    <td width="200"><b><?php echo $lang['network']; ?></b></td>
    <td width="260"><b><?php echo $lang['desc']; ?></b></td>
    <td width="150"><b><?php echo $lang['status']; ?></b></td>
    <td width="80"><b><?php echo $lang['manage']; ?></b></td>
  </tr>
  
  <?php
  // Game or voice or all
  $url_type = $GPXIN['t'];
  if($url_type == 'g') $sql_where = "WHERE d.type = 'game'";
  elseif($url_type == 'v') $sql_where = "WHERE d.type = 'voice'";
  else $sql_where = '';
  
  // Page number
  $pagenum = $GPXIN['pagenum'];
  $per_page = 15;
  if($pagenum) $sql_limit = $pagenum * $per_page . ',15';
  else $sql_limit = '0,15';

  // Get total servers
  $result_total  = $GLOBALS['mysqli']->query("SELECT 
                                     COUNT(*) AS cnt 
                                 FROM servers AS s 
                                 LEFT JOIN default_games AS d ON 
                                     s.defid = d.id
                                 $sql_where") or die('Failed to count servers: '.$GLOBALS['mysqli']->error.'!');

  $row_srv       = $result_total->fetch_row();
  $total_servers = $row_srv[0];

  // List servers
  $result_srv = $GLOBALS['mysqli']->query("SELECT 
                                s.id,
                                s.userid,
                                s.port,
                                s.status,
                                s.description,
                                d.intname,
                                d.gameq_name,
                                d.name,
                                n.ip,
                                u.username 
                              FROM servers AS s 
                              LEFT JOIN default_games AS d ON 
                                s.defid = d.id 
                              LEFT JOIN network AS n ON 
                                s.netid = n.id 
                              LEFT JOIN users AS u ON 
                                s.userid = u.id 
                              $sql_where 
                              ORDER BY 
                                s.id DESC,
                                n.ip ASC 
                              LIMIT $sql_limit") or die($lang['err_query'].' ('.$GLOBALS['mysqli']->error.')');
  
  $json_arr = array();
  $count_json = 0;
  
  while($row_srv  = $result_srv->fetch_array())
  {
      $srv_id           = $row_srv['id'];
      $srv_userid       = $row_srv['userid'];
      $srv_ip           = $row_srv['ip'];
      $srv_port         = $row_srv['port'];
      $srv_status       = $row_srv['status'];
      $srv_description  = $row_srv['description'];
      $srv_def_name     = $row_srv['name'];
      $srv_def_intname  = $row_srv['intname'];
      $srv_gameq_name   = $row_srv['gameq_name'];
      $srv_username     = $row_srv['username'];
      
      // Add to JSON arry (only if complete)
      if($srv_status == 'complete')
      {
          if($srv_id)               $json_arr[$count_json]['id']    = $srv_id;
          if($srv_ip && $srv_port)  $json_arr[$count_json]['host']  = $srv_ip . ':' . $srv_port;
          if($srv_gameq_name)       $json_arr[$count_json]['type']  = $srv_gameq_name;
      }
      
      // Use correct status; if complete, show online/offline
      if($srv_status == 'installing')
      {
          $srv_status = '<font color="blue">'.$lang['installing'].' ...</font>';
      }
      elseif($srv_status == 'failed')
      {
          $srv_status = '<font color="red">'.$lang['failed'].'!</font>';
      }
      elseif($srv_status == 'none')
      {
          $srv_status = '<font color="orange">'.$lang['unknown'].'</font>';
      }
      
      echo '<tr id="srv_' . $srv_id . '" style="cursor:pointer;" onClick="javascript:server_tab_info(' . $srv_id . ');">
              <td><img src="../images/gameicons/small/' . $srv_def_intname . '.png" width="20" height="20" border="0" /></td>
              <td>' . $srv_def_name . '</td>
              <td>' . $srv_username . '</td>
              <td>' . $srv_ip . ':' . $srv_port . '</td>
              <td style="font-size:10pt;">' . $srv_description . '</td>
              
              <td id="statustd_' . $srv_id . '">'.$srv_status;
              
              // Connected Players
              #if($gameq_status == 'online') echo '&nbsp;<span style="font-size:8pt;color:#777;">' . $gameq_numplayers . '/' . $gameq_maxplayers . '</span>';
              #else echo '&nbsp;';
              
              echo '</td>
              <td class="links">'.$lang['manage'].'</td>
            </tr>';
  
      $count_json++;
  }
  
  $json_str = json_encode($json_arr);
  ?>
  <!--
  <tr id="srv_table_ld_tr">
    <td colspan="7" align="left" id="srv_table_ld_td">&nbsp;</td>
  </tr>
  -->
<?php $Plugins->do_action('servers_table'); // Plugins ?>
</table>


<?php
// Server Paging
if($total_servers > 15) {
	$total_pages = round($total_servers / 15);
	
	echo '<span style="font-size:9pt;">Page: </span> ';

	for($i=0; $i <= $total_pages; $i++) {
		if($pagenum == $i) echo '<span style="font-size:9pt;font-style:italic;">'.$i.' </span> ';
		else echo '<span onClick="javascript:mainpage(\'servers\',\'\',\'&pagenum='.$i.'\');" class="links">'.$i.' </span> ';
	}
}
else {
	echo '<span style="font-size:9pt;margin-left:10px;">Page: 0</span><br />';
}

echo '<br /><span style="font-size:9pt;margin-left:10px;">'. $lang['servers'] . ': '.$total_servers.'</span><br /><br />';
?>

<script type="text/javascript">
$(document).ready(function(){
    setTimeout("multi_query()", 200);
});
</script>

<input type='hidden' id='json_hid' value='<?php echo $json_str; ?>' />

<?php $Plugins->do_action('servers_bottom'); // Plugins ?>



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
    .cfg_table tr{
        border: 1px solid black;
    }

</style>


</div>
