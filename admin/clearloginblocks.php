<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION['gpx_userid']) || !isset($_SESSION['gpx_admin'])) die('Please login');

// $Plugins->do_action('home_top'); // Plugins

// Debug info

?>


<div class="infobox" style="display:none;"></div>


<div class="container" style="color:white !important;font-size:15px;width:100%;">

  <header>
    <div class="fa fa-gear"></div>
    <div class="title">Clear Login Blocks</div>
  </header>

  <div class="content-wrapper" style="width:76%">
    <form id="SubuserForm" action="#" method="post">
      <table border="0" cellpadding="0" cellspacing="0" align="center" width="900" id="srv_table" class="box_table" style="text-align:left;">
        <tr>
          <td width="25">&nbsp;</td>
          <td width="300"><b><?php echo "Blocked User ID" ?></b></td>
          <td width="240"><b><?php echo "Blocked Users - Username" ?></b></td>
          <td width="240"><b><?php echo "Unblock User" ?></b></td>
        </tr>
        <?php
        include('../configuration.php');
        $servername = $settings['db_host'] ;
        $username = $settings['db_username'];
        $password = $settings['db_password'];
        $dbname = $settings['db_name'];
        //get total blocked users
        $conn = mysqli_connect($servername,$username,$password,$dbname);
        $result_total  = mysqli_query($conn, "SELECT
          id
          FROM users
          WHERE login_attempts = 5");
          $row_srv       = $result_total->fetch_row();
          $total_servers = $row_srv[0];

        // List server
        // Get the blocked users
      $result_srv = mysqli_query($conn, "SELECT
                                          id,
                                          username,
                                          active
                                          FROM users
                                          WHERE login_attempts = 5") or die($lang['err_query'].' ('.$GLOBALS['mysqli']->error.')');

      while($row_srv = $result_srv->fetch_array()){
      $blocked_ID = $row_srv['id'];
      //Get The Username
      $block_usernames = mysqli_query($conn, "SELECT
              username
              FROM users
              WHERE id = '$blocked_ID'") or die($lang['err_query'].' ('.$GLOBALS['mysqli']->error.')');
      while($username = $block_usernames->fetch_array())
      $blocked_Username = $username['username'];
      // Makes sure if there is a blocked user
      if ($blocked_ID != '') {
      echo "<tr>  <td></td> <td>" . $blocked_ID . "</td><td>" . $blocked_Username . "</td> <td> <button type='button' onclick='unblock(".$blocked_ID.");'  class='btn btn-default waves-effect waves-light'>Clear Login Block</button></td> </tr>";
  }
    else {
      echo "<tr><td colspan='4'>No Blocked Users</td></tr>";
    }
  }

      ?>
      </table>
    </form>
    </div>
  </div>

<script type="text/javascript">
  function unblock(id){
      var userid = id;
      $.ajax({
        type:'POST',
        data:{ id : id , somevar : "yes"  },
        url:'../ajax/clearloginblock.php',
      });
  }
</script>

<!--

<form id="SubuserForm" action="#" method="post">
    <input  name="ServerID"  id="ServerID" value="" tabindex="5"  type="text">
    <input  name="UserID2"  id="UserID2" value="" tabindex="5"  type="text">
	<input type="submit" name="Update" id="update" value="Update" />
 </form> -->






 <script>
 // Check for system updates
 $(document).ready(function(){
     setTimeout("cloud_check_updates()", 500);
 });
 $("#update").click(function(e) {
   e.preventDefault();
   var serverid = $("#ServerID").val();
   var UserID2 = $("#UserID2").val();
   console.log(serverid);
   console.log(UserID2);
   $.ajax({
     type:'POST',
     data:{ serverid : serverid , UserID2 : UserID2, somevar : "yes"  },
     url:'../ajax/addsubuser.php',
     success:function(data) {
       alert(data);
     }
   });
 });

function enablemaint(){
  $.ajax({
    type:'POST',
    url:'../ajax/enablemaint.php',
    success:function(data) {
      alert(data);
    }
  });
}
function disablemaint(){
  $.ajax({
    type:'POST',
    url:'../ajax/disablemaint.php',
    success:function(data) {
      alert(data);
    }
  });
}




 ;(function(window) {
     'use strict';

     var Waves = Waves || {};
     var $$ = document.querySelectorAll.bind(document);

     // Find exact position of element
     function isWindow(obj) {
         return obj !== null && obj === obj.window;
     }

     function getWindow(elem) {
         return isWindow(elem) ? elem : elem.nodeType === 9 && elem.defaultView;
     }

     function offset(elem) {
         var docElem, win,
             box = {top: 0, left: 0},
             doc = elem && elem.ownerDocument;

         docElem = doc.documentElement;

         if (typeof elem.getBoundingClientRect !== typeof undefined) {
             box = elem.getBoundingClientRect();
         }
         win = getWindow(doc);
         return {
             top: box.top + win.pageYOffset - docElem.clientTop,
             left: box.left + win.pageXOffset - docElem.clientLeft
         };
     }

     function convertStyle(obj) {
         var style = '';

         for (var a in obj) {
             if (obj.hasOwnProperty(a)) {
                 style += (a + ':' + obj[a] + ';');
             }
         }

         return style;
     }

     var Effect = {

         // Effect delay
         duration: 750,

         show: function(e, element) {

             // Disable right click
             if (e.button === 2) {
                 return false;
             }

             var el = element || this;

             // Create ripple
             var ripple = document.createElement('div');
             ripple.className = 'waves-ripple';
             el.appendChild(ripple);

             // Get click coordinate and element witdh
             var pos         = offset(el);
             var relativeY   = (e.pageY - pos.top);
             var relativeX   = (e.pageX - pos.left);
             var scale       = 'scale('+((el.clientWidth / 100) * 10)+')';

             // Support for touch devices
             if ('touches' in e) {
               relativeY   = (e.touches[0].pageY - pos.top);
               relativeX   = (e.touches[0].pageX - pos.left);
             }

             // Attach data to element
             ripple.setAttribute('data-hold', Date.now());
             ripple.setAttribute('data-scale', scale);
             ripple.setAttribute('data-x', relativeX);
             ripple.setAttribute('data-y', relativeY);

             // Set ripple position
             var rippleStyle = {
                 'top': relativeY+'px',
                 'left': relativeX+'px'
             };

             ripple.className = ripple.className + ' waves-notransition';
             ripple.setAttribute('style', convertStyle(rippleStyle));
             ripple.className = ripple.className.replace('waves-notransition', '');

             // Scale the ripple
             rippleStyle['-webkit-transform'] = scale;
             rippleStyle['-moz-transform'] = scale;
             rippleStyle['-ms-transform'] = scale;
             rippleStyle['-o-transform'] = scale;
             rippleStyle.transform = scale;
             rippleStyle.opacity   = '1';

             rippleStyle['-webkit-transition-duration'] = Effect.duration + 'ms';
             rippleStyle['-moz-transition-duration']    = Effect.duration + 'ms';
             rippleStyle['-o-transition-duration']      = Effect.duration + 'ms';
             rippleStyle['transition-duration']         = Effect.duration + 'ms';

             rippleStyle['-webkit-transition-timing-function'] = 'cubic-bezier(0.250, 0.460, 0.450, 0.940)';
             rippleStyle['-moz-transition-timing-function']    = 'cubic-bezier(0.250, 0.460, 0.450, 0.940)';
             rippleStyle['-o-transition-timing-function']      = 'cubic-bezier(0.250, 0.460, 0.450, 0.940)';
             rippleStyle['transition-timing-function']         = 'cubic-bezier(0.250, 0.460, 0.450, 0.940)';

             ripple.setAttribute('style', convertStyle(rippleStyle));
         },

         hide: function(e) {
             TouchHandler.touchup(e);

             var el = this;
             var width = el.clientWidth * 1.4;

             // Get first ripple
             var ripple = null;
             var ripples = el.getElementsByClassName('waves-ripple');
             if (ripples.length > 0) {
                 ripple = ripples[ripples.length - 1];
             } else {
                 return false;
             }

             var relativeX   = ripple.getAttribute('data-x');
             var relativeY   = ripple.getAttribute('data-y');
             var scale       = ripple.getAttribute('data-scale');

             // Get delay beetween mousedown and mouse leave
             var diff = Date.now() - Number(ripple.getAttribute('data-hold'));
             var delay = 350 - diff;

             if (delay < 0) {
                 delay = 0;
             }

             // Fade out ripple after delay
             setTimeout(function() {
                 var style = {
                     'top': relativeY+'px',
                     'left': relativeX+'px',
                     'opacity': '0',

                     // Duration
                     '-webkit-transition-duration': Effect.duration + 'ms',
                     '-moz-transition-duration': Effect.duration + 'ms',
                     '-o-transition-duration': Effect.duration + 'ms',
                     'transition-duration': Effect.duration + 'ms',
                     '-webkit-transform': scale,
                     '-moz-transform': scale,
                     '-ms-transform': scale,
                     '-o-transform': scale,
                     'transform': scale,
                 };

                 ripple.setAttribute('style', convertStyle(style));

                 setTimeout(function() {
                     try {
                         el.removeChild(ripple);
                     } catch(e) {
                         return false;
                     }
                 }, Effect.duration);
             }, delay);
         },

         // Little hack to make <input> can perform waves effect
         wrapInput: function(elements) {
             for (var a = 0; a < elements.length; a++) {
                 var el = elements[a];

                 if (el.tagName.toLowerCase() === 'input') {
                     var parent = el.parentNode;

                     // If input already have parent just pass through
                     if (parent.tagName.toLowerCase() === 'i' && parent.className.indexOf('waves-effect') !== -1) {
                         continue;
                     }

                     // Put element class and style to the specified parent
                     var wrapper = document.createElement('i');
                     wrapper.className = el.className + ' waves-input-wrapper';

                     var elementStyle = el.getAttribute('style');

                     if (!elementStyle) {
                         elementStyle = '';
                     }

                     wrapper.setAttribute('style', elementStyle);

                     el.className = 'waves-button-input';
                     el.removeAttribute('style');

                     // Put element as child
                     parent.replaceChild(wrapper, el);
                     wrapper.appendChild(el);
                 }
             }
         }
     };


     /**
      * Disable mousedown event for 500ms during and after touch
      */
     var TouchHandler = {
         /* uses an integer rather than bool so there's no issues with
          * needing to clear timeouts if another touch event occurred
          * within the 500ms. Cannot mouseup between touchstart and
          * touchend, nor in the 500ms after touchend. */
         touches: 0,
         allowEvent: function(e) {
             var allow = true;

             if (e.type === 'touchstart') {
                 TouchHandler.touches += 1; //push
             } else if (e.type === 'touchend' || e.type === 'touchcancel') {
                 setTimeout(function() {
                     if (TouchHandler.touches > 0) {
                         TouchHandler.touches -= 1; //pop after 500ms
                     }
                 }, 500);
             } else if (e.type === 'mousedown' && TouchHandler.touches > 0) {
                 allow = false;
             }

             return allow;
         },
         touchup: function(e) {
             TouchHandler.allowEvent(e);
         }
     };


     /**
      * Delegated click handler for .waves-effect element.
      * returns null when .waves-effect element not in "click tree"
      */
     function getWavesEffectElement(e) {
         if (TouchHandler.allowEvent(e) === false) {
             return null;
         }

         var element = null;
         var target = e.target || e.srcElement;

         while (target.parentElement !== null) {
             if (!(target instanceof SVGElement) && target.className.indexOf('waves-effect') !== -1) {
                 element = target;
                 break;
             } else if (target.classList.contains('waves-effect')) {
                 element = target;
                 break;
             }
             target = target.parentElement;
         }

         return element;
     }

     /**
      * Bubble the click and show effect if .waves-effect elem was found
      */
     function showEffect(e) {
         var element = getWavesEffectElement(e);

         if (element !== null) {
             Effect.show(e, element);

             if ('ontouchstart' in window) {
                 element.addEventListener('touchend', Effect.hide, false);
                 element.addEventListener('touchcancel', Effect.hide, false);
             }

             element.addEventListener('mouseup', Effect.hide, false);
             element.addEventListener('mouseleave', Effect.hide, false);
         }
     }

     Waves.displayEffect = function(options) {
         options = options || {};

         if ('duration' in options) {
             Effect.duration = options.duration;
         }

         //Wrap input inside <i> tag
         Effect.wrapInput($$('.waves-effect'));

         if ('ontouchstart' in window) {
             document.body.addEventListener('touchstart', showEffect, false);
         }

         document.body.addEventListener('mousedown', showEffect, false);
     };

     /**
      * Attach Waves to an input element (or any element which doesn't
      * bubble mouseup/mousedown events).
      *   Intended to be used with dynamically loaded forms/inputs, or
      * where the user doesn't want a delegated click handler.
      */
     Waves.attach = function(element) {
         //FUTURE: automatically add waves classes and allow users
         // to specify them with an options param? Eg. light/classic/button
         if (element.tagName.toLowerCase() === 'input') {
             Effect.wrapInput([element]);
             element = element.parentElement;
         }

         if ('ontouchstart' in window) {
             element.addEventListener('touchstart', showEffect, false);
         }

         element.addEventListener('mousedown', showEffect, false);
     };

     window.Waves = Waves;

     document.addEventListener('DOMContentLoaded', function() {
         Waves.displayEffect();
     }, false);

 })(window);


 </script>

<style media="screen">
@import url("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css");

.materialize-red.lighten-5 {
background-color: #fdeaeb !important;
}

.materialize-red-text.text-lighten-5 {
color: #fdeaeb !important;
}

.materialize-red.lighten-4 {
background-color: #f8c1c3 !important;
}

.materialize-red-text.text-lighten-4 {
color: #f8c1c3 !important;
}

.materialize-red.lighten-3 {
background-color: #f3989b !important;
}

.materialize-red-text.text-lighten-3 {
color: #f3989b !important;
}

.materialize-red.lighten-2 {
background-color: #ee6e73 !important;
}

.materialize-red-text.text-lighten-2 {
color: #ee6e73 !important;
}

.materialize-red.lighten-1 {
background-color: #ea454b !important;
}

.materialize-red-text.text-lighten-1 {
color: #ea454b !important;
}

.materialize-red {
background-color: #e51c23 !important;
}

.materialize-red-text {
color: #e51c23 !important;
}

.materialize-red.darken-1 {
background-color: #d0181e !important;
}

.materialize-red-text.text-darken-1 {
color: #d0181e !important;
}

.materialize-red.darken-2 {
background-color: #b9151b !important;
}

.materialize-red-text.text-darken-2 {
color: #b9151b !important;
}

.materialize-red.darken-3 {
background-color: #a21318 !important;
}

.materialize-red-text.text-darken-3 {
color: #a21318 !important;
}

.materialize-red.darken-4 {
background-color: #8b1014 !important;
}

.materialize-red-text.text-darken-4 {
color: #8b1014 !important;
}

.red.lighten-5 {
background-color: #FFEBEE !important;
}

.red-text.text-lighten-5 {
color: #FFEBEE !important;
}

.red.lighten-4 {
background-color: #FFCDD2 !important;
}

.red-text.text-lighten-4 {
color: #FFCDD2 !important;
}

.red.lighten-3 {
background-color: #EF9A9A !important;
}

.red-text.text-lighten-3 {
color: #EF9A9A !important;
}

.red.lighten-2 {
background-color: #E57373 !important;
}

.red-text.text-lighten-2 {
color: #E57373 !important;
}

.red.lighten-1 {
background-color: #EF5350 !important;
}

.red-text.text-lighten-1 {
color: #EF5350 !important;
}

.red {
background-color: #F44336 !important;
}

.red-text {
color: #F44336 !important;
}

.red.darken-1 {
background-color: #E53935 !important;
}

.red-text.text-darken-1 {
color: #E53935 !important;
}

.red.darken-2 {
background-color: #D32F2F !important;
}

.red-text.text-darken-2 {
color: #D32F2F !important;
}

.red.darken-3 {
background-color: #C62828 !important;
}

.red-text.text-darken-3 {
color: #C62828 !important;
}

.red.darken-4 {
background-color: #B71C1C !important;
}

.red-text.text-darken-4 {
color: #B71C1C !important;
}

.red.accent-1 {
background-color: #FF8A80 !important;
}

.red-text.text-accent-1 {
color: #FF8A80 !important;
}

.red.accent-2 {
background-color: #FF5252 !important;
}

.red-text.text-accent-2 {
color: #FF5252 !important;
}

.red.accent-3 {
background-color: #FF1744 !important;
}

.red-text.text-accent-3 {
color: #FF1744 !important;
}

.red.accent-4 {
background-color: #D50000 !important;
}

.red-text.text-accent-4 {
color: #D50000 !important;
}

.pink.lighten-5 {
background-color: #fce4ec !important;
}

.pink-text.text-lighten-5 {
color: #fce4ec !important;
}

.pink.lighten-4 {
background-color: #f8bbd0 !important;
}

.pink-text.text-lighten-4 {
color: #f8bbd0 !important;
}

.pink.lighten-3 {
background-color: #f48fb1 !important;
}

.pink-text.text-lighten-3 {
color: #f48fb1 !important;
}

.pink.lighten-2 {
background-color: #f06292 !important;
}

.pink-text.text-lighten-2 {
color: #f06292 !important;
}

.pink.lighten-1 {
background-color: #ec407a !important;
}

.pink-text.text-lighten-1 {
color: #ec407a !important;
}

.pink {
background-color: #e91e63 !important;
}

.pink-text {
color: #e91e63 !important;
}

.pink.darken-1 {
background-color: #d81b60 !important;
}

.pink-text.text-darken-1 {
color: #d81b60 !important;
}

.pink.darken-2 {
background-color: #c2185b !important;
}

.pink-text.text-darken-2 {
color: #c2185b !important;
}

.pink.darken-3 {
background-color: #ad1457 !important;
}

.pink-text.text-darken-3 {
color: #ad1457 !important;
}

.pink.darken-4 {
background-color: #880e4f !important;
}

.pink-text.text-darken-4 {
color: #880e4f !important;
}

.pink.accent-1 {
background-color: #ff80ab !important;
}

.pink-text.text-accent-1 {
color: #ff80ab !important;
}

.pink.accent-2 {
background-color: #ff4081 !important;
}

.pink-text.text-accent-2 {
color: #ff4081 !important;
}

.pink.accent-3 {
background-color: #f50057 !important;
}

.pink-text.text-accent-3 {
color: #f50057 !important;
}

.pink.accent-4 {
background-color: #c51162 !important;
}

.pink-text.text-accent-4 {
color: #c51162 !important;
}

.purple.lighten-5 {
background-color: #f3e5f5 !important;
}

.purple-text.text-lighten-5 {
color: #f3e5f5 !important;
}

.purple.lighten-4 {
background-color: #e1bee7 !important;
}

.purple-text.text-lighten-4 {
color: #e1bee7 !important;
}

.purple.lighten-3 {
background-color: #ce93d8 !important;
}

.purple-text.text-lighten-3 {
color: #ce93d8 !important;
}

.purple.lighten-2 {
background-color: #ba68c8 !important;
}

.purple-text.text-lighten-2 {
color: #ba68c8 !important;
}

.purple.lighten-1 {
background-color: #ab47bc !important;
}

.purple-text.text-lighten-1 {
color: #ab47bc !important;
}

.purple {
background-color: #9c27b0 !important;
}

.purple-text {
color: #9c27b0 !important;
}

.purple.darken-1 {
background-color: #8e24aa !important;
}

.purple-text.text-darken-1 {
color: #8e24aa !important;
}

.purple.darken-2 {
background-color: #7b1fa2 !important;
}

.purple-text.text-darken-2 {
color: #7b1fa2 !important;
}

.purple.darken-3 {
background-color: #6a1b9a !important;
}

.purple-text.text-darken-3 {
color: #6a1b9a !important;
}

.purple.darken-4 {
background-color: #4a148c !important;
}

.purple-text.text-darken-4 {
color: #4a148c !important;
}

.purple.accent-1 {
background-color: #ea80fc !important;
}

.purple-text.text-accent-1 {
color: #ea80fc !important;
}

.purple.accent-2 {
background-color: #e040fb !important;
}

.purple-text.text-accent-2 {
color: #e040fb !important;
}

.purple.accent-3 {
background-color: #d500f9 !important;
}

.purple-text.text-accent-3 {
color: #d500f9 !important;
}

.purple.accent-4 {
background-color: #aa00ff !important;
}

.purple-text.text-accent-4 {
color: #aa00ff !important;
}

.deep-purple.lighten-5 {
background-color: #ede7f6 !important;
}

.deep-purple-text.text-lighten-5 {
color: #ede7f6 !important;
}

.deep-purple.lighten-4 {
background-color: #d1c4e9 !important;
}

.deep-purple-text.text-lighten-4 {
color: #d1c4e9 !important;
}

.deep-purple.lighten-3 {
background-color: #b39ddb !important;
}

.deep-purple-text.text-lighten-3 {
color: #b39ddb !important;
}

.deep-purple.lighten-2 {
background-color: #9575cd !important;
}

.deep-purple-text.text-lighten-2 {
color: #9575cd !important;
}

.deep-purple.lighten-1 {
background-color: #7e57c2 !important;
}

.deep-purple-text.text-lighten-1 {
color: #7e57c2 !important;
}

.deep-purple {
background-color: #673ab7 !important;
}

.deep-purple-text {
color: #673ab7 !important;
}

.deep-purple.darken-1 {
background-color: #5e35b1 !important;
}

.deep-purple-text.text-darken-1 {
color: #5e35b1 !important;
}

.deep-purple.darken-2 {
background-color: #512da8 !important;
}

.deep-purple-text.text-darken-2 {
color: #512da8 !important;
}

.deep-purple.darken-3 {
background-color: #4527a0 !important;
}

.deep-purple-text.text-darken-3 {
color: #4527a0 !important;
}

.deep-purple.darken-4 {
background-color: #311b92 !important;
}

.deep-purple-text.text-darken-4 {
color: #311b92 !important;
}

.deep-purple.accent-1 {
background-color: #b388ff !important;
}

.deep-purple-text.text-accent-1 {
color: #b388ff !important;
}

.deep-purple.accent-2 {
background-color: #7c4dff !important;
}

.deep-purple-text.text-accent-2 {
color: #7c4dff !important;
}

.deep-purple.accent-3 {
background-color: #651fff !important;
}

.deep-purple-text.text-accent-3 {
color: #651fff !important;
}

.deep-purple.accent-4 {
background-color: #6200ea !important;
}

.deep-purple-text.text-accent-4 {
color: #6200ea !important;
}

.indigo.lighten-5 {
background-color: #e8eaf6 !important;
}

.indigo-text.text-lighten-5 {
color: #e8eaf6 !important;
}

.indigo.lighten-4 {
background-color: #c5cae9 !important;
}

.indigo-text.text-lighten-4 {
color: #c5cae9 !important;
}

.indigo.lighten-3 {
background-color: #9fa8da !important;
}

.indigo-text.text-lighten-3 {
color: #9fa8da !important;
}

.indigo.lighten-2 {
background-color: #7986cb !important;
}

.indigo-text.text-lighten-2 {
color: #7986cb !important;
}

.indigo.lighten-1 {
background-color: #5c6bc0 !important;
}

.indigo-text.text-lighten-1 {
color: #5c6bc0 !important;
}

.indigo {
background-color: #3f51b5 !important;
}

.indigo-text {
color: #3f51b5 !important;
}

.indigo.darken-1 {
background-color: #3949ab !important;
}

.indigo-text.text-darken-1 {
color: #3949ab !important;
}

.indigo.darken-2 {
background-color: #303f9f !important;
}

.indigo-text.text-darken-2 {
color: #303f9f !important;
}

.indigo.darken-3 {
background-color: #283593 !important;
}

.indigo-text.text-darken-3 {
color: #283593 !important;
}

.indigo.darken-4 {
background-color: #1a237e !important;
}

.indigo-text.text-darken-4 {
color: #1a237e !important;
}

.indigo.accent-1 {
background-color: #8c9eff !important;
}

.indigo-text.text-accent-1 {
color: #8c9eff !important;
}

.indigo.accent-2 {
background-color: #536dfe !important;
}

.indigo-text.text-accent-2 {
color: #536dfe !important;
}

.indigo.accent-3 {
background-color: #3d5afe !important;
}

.indigo-text.text-accent-3 {
color: #3d5afe !important;
}

.indigo.accent-4 {
background-color: #304ffe !important;
}

.indigo-text.text-accent-4 {
color: #304ffe !important;
}

.blue.lighten-5 {
background-color: #E3F2FD !important;
}

.blue-text.text-lighten-5 {
color: #E3F2FD !important;
}

.blue.lighten-4 {
background-color: #BBDEFB !important;
}

.blue-text.text-lighten-4 {
color: #BBDEFB !important;
}

.blue.lighten-3 {
background-color: #90CAF9 !important;
}

.blue-text.text-lighten-3 {
color: #90CAF9 !important;
}

.blue.lighten-2 {
background-color: #64B5F6 !important;
}

.blue-text.text-lighten-2 {
color: #64B5F6 !important;
}

.blue.lighten-1 {
background-color: #42A5F5 !important;
}

.blue-text.text-lighten-1 {
color: #42A5F5 !important;
}

.blue {
background-color: #2196F3 !important;
}

.blue-text {
color: #2196F3 !important;
}

.blue.darken-1 {
background-color: #1E88E5 !important;
}

.blue-text.text-darken-1 {
color: #1E88E5 !important;
}

.blue.darken-2 {
background-color: #1976D2 !important;
}

.blue-text.text-darken-2 {
color: #1976D2 !important;
}

.blue.darken-3 {
background-color: #1565C0 !important;
}

.blue-text.text-darken-3 {
color: #1565C0 !important;
}

.blue.darken-4 {
background-color: #0D47A1 !important;
}

.blue-text.text-darken-4 {
color: #0D47A1 !important;
}

.blue.accent-1 {
background-color: #82B1FF !important;
}

.blue-text.text-accent-1 {
color: #82B1FF !important;
}

.blue.accent-2 {
background-color: #448AFF !important;
}

.blue-text.text-accent-2 {
color: #448AFF !important;
}

.blue.accent-3 {
background-color: #2979FF !important;
}

.blue-text.text-accent-3 {
color: #2979FF !important;
}

.blue.accent-4 {
background-color: #2962FF !important;
}

.blue-text.text-accent-4 {
color: #2962FF !important;
}

.light-blue.lighten-5 {
background-color: #e1f5fe !important;
}

.light-blue-text.text-lighten-5 {
color: #e1f5fe !important;
}

.light-blue.lighten-4 {
background-color: #b3e5fc !important;
}

.light-blue-text.text-lighten-4 {
color: #b3e5fc !important;
}

.light-blue.lighten-3 {
background-color: #81d4fa !important;
}

.light-blue-text.text-lighten-3 {
color: #81d4fa !important;
}

.light-blue.lighten-2 {
background-color: #4fc3f7 !important;
}

.light-blue-text.text-lighten-2 {
color: #4fc3f7 !important;
}

.light-blue.lighten-1 {
background-color: #29b6f6 !important;
}

.light-blue-text.text-lighten-1 {
color: #29b6f6 !important;
}

.light-blue {
background-color: #03a9f4 !important;
}

.light-blue-text {
color: #03a9f4 !important;
}

.light-blue.darken-1 {
background-color: #039be5 !important;
}

.light-blue-text.text-darken-1 {
color: #039be5 !important;
}

.light-blue.darken-2 {
background-color: #0288d1 !important;
}

.light-blue-text.text-darken-2 {
color: #0288d1 !important;
}

.light-blue.darken-3 {
background-color: #0277bd !important;
}

.light-blue-text.text-darken-3 {
color: #0277bd !important;
}

.light-blue.darken-4 {
background-color: #01579b !important;
}

.light-blue-text.text-darken-4 {
color: #01579b !important;
}

.light-blue.accent-1 {
background-color: #80d8ff !important;
}

.light-blue-text.text-accent-1 {
color: #80d8ff !important;
}

.light-blue.accent-2 {
background-color: #40c4ff !important;
}

.light-blue-text.text-accent-2 {
color: #40c4ff !important;
}

.light-blue.accent-3 {
background-color: #00b0ff !important;
}

.light-blue-text.text-accent-3 {
color: #00b0ff !important;
}

.light-blue.accent-4 {
background-color: #0091ea !important;
}

.light-blue-text.text-accent-4 {
color: #0091ea !important;
}

.cyan.lighten-5 {
background-color: #e0f7fa !important;
}

.cyan-text.text-lighten-5 {
color: #e0f7fa !important;
}

.cyan.lighten-4 {
background-color: #b2ebf2 !important;
}

.cyan-text.text-lighten-4 {
color: #b2ebf2 !important;
}

.cyan.lighten-3 {
background-color: #80deea !important;
}

.cyan-text.text-lighten-3 {
color: #80deea !important;
}

.cyan.lighten-2 {
background-color: #4dd0e1 !important;
}

.cyan-text.text-lighten-2 {
color: #4dd0e1 !important;
}

.cyan.lighten-1 {
background-color: #26c6da !important;
}

.cyan-text.text-lighten-1 {
color: #26c6da !important;
}

.cyan {
background-color: #00bcd4 !important;
}

.cyan-text {
color: #00bcd4 !important;
}

.cyan.darken-1 {
background-color: #00acc1 !important;
}

.cyan-text.text-darken-1 {
color: #00acc1 !important;
}

.cyan.darken-2 {
background-color: #0097a7 !important;
}

.cyan-text.text-darken-2 {
color: #0097a7 !important;
}

.cyan.darken-3 {
background-color: #00838f !important;
}

.cyan-text.text-darken-3 {
color: #00838f !important;
}

.cyan.darken-4 {
background-color: #006064 !important;
}

.cyan-text.text-darken-4 {
color: #006064 !important;
}

.cyan.accent-1 {
background-color: #84ffff !important;
}

.cyan-text.text-accent-1 {
color: #84ffff !important;
}

.cyan.accent-2 {
background-color: #18ffff !important;
}

.cyan-text.text-accent-2 {
color: #18ffff !important;
}

.cyan.accent-3 {
background-color: #00e5ff !important;
}

.cyan-text.text-accent-3 {
color: #00e5ff !important;
}

.cyan.accent-4 {
background-color: #00b8d4 !important;
}

.cyan-text.text-accent-4 {
color: #00b8d4 !important;
}

.teal.lighten-5 {
background-color: #e0f2f1 !important;
}

.teal-text.text-lighten-5 {
color: #e0f2f1 !important;
}

.teal.lighten-4 {
background-color: #b2dfdb !important;
}

.teal-text.text-lighten-4 {
color: #b2dfdb !important;
}

.teal.lighten-3 {
background-color: #80cbc4 !important;
}

.teal-text.text-lighten-3 {
color: #80cbc4 !important;
}

.teal.lighten-2 {
background-color: #4db6ac !important;
}

.teal-text.text-lighten-2 {
color: #4db6ac !important;
}

.teal.lighten-1 {
background-color: #26a69a !important;
}

.teal-text.text-lighten-1 {
color: #26a69a !important;
}

.teal {
background-color: #009688 !important;
}

.teal-text {
color: #009688 !important;
}

.teal.darken-1 {
background-color: #00897b !important;
}

.teal-text.text-darken-1 {
color: #00897b !important;
}

.teal.darken-2 {
background-color: #00796b !important;
}

.teal-text.text-darken-2 {
color: #00796b !important;
}

.teal.darken-3 {
background-color: #00695c !important;
}

.teal-text.text-darken-3 {
color: #00695c !important;
}

.teal.darken-4 {
background-color: #004d40 !important;
}

.teal-text.text-darken-4 {
color: #004d40 !important;
}

.teal.accent-1 {
background-color: #a7ffeb !important;
}

.teal-text.text-accent-1 {
color: #a7ffeb !important;
}

.teal.accent-2 {
background-color: #64ffda !important;
}

.teal-text.text-accent-2 {
color: #64ffda !important;
}

.teal.accent-3 {
background-color: #1de9b6 !important;
}

.teal-text.text-accent-3 {
color: #1de9b6 !important;
}

.teal.accent-4 {
background-color: #00bfa5 !important;
}

.teal-text.text-accent-4 {
color: #00bfa5 !important;
}

.green.lighten-5 {
background-color: #E8F5E9 !important;
}

.green-text.text-lighten-5 {
color: #E8F5E9 !important;
}

.green.lighten-4 {
background-color: #C8E6C9 !important;
}

.green-text.text-lighten-4 {
color: #C8E6C9 !important;
}

.green.lighten-3 {
background-color: #A5D6A7 !important;
}

.green-text.text-lighten-3 {
color: #A5D6A7 !important;
}

.green.lighten-2 {
background-color: #81C784 !important;
}

.green-text.text-lighten-2 {
color: #81C784 !important;
}

.green.lighten-1 {
background-color: #66BB6A !important;
}

.green-text.text-lighten-1 {
color: #66BB6A !important;
}

.green {
background-color: #4CAF50 !important;
}

.green-text {
color: #4CAF50 !important;
}

.green.darken-1 {
background-color: #43A047 !important;
}

.green-text.text-darken-1 {
color: #43A047 !important;
}

.green.darken-2 {
background-color: #388E3C !important;
}

.green-text.text-darken-2 {
color: #388E3C !important;
}

.green.darken-3 {
background-color: #2E7D32 !important;
}

.green-text.text-darken-3 {
color: #2E7D32 !important;
}

.green.darken-4 {
background-color: #1B5E20 !important;
}

.green-text.text-darken-4 {
color: #1B5E20 !important;
}

.green.accent-1 {
background-color: #B9F6CA !important;
}

.green-text.text-accent-1 {
color: #B9F6CA !important;
}

.green.accent-2 {
background-color: #69F0AE !important;
}

.green-text.text-accent-2 {
color: #69F0AE !important;
}

.green.accent-3 {
background-color: #00E676 !important;
}

.green-text.text-accent-3 {
color: #00E676 !important;
}

.green.accent-4 {
background-color: #00C853 !important;
}

.green-text.text-accent-4 {
color: #00C853 !important;
}

.light-green.lighten-5 {
background-color: #f1f8e9 !important;
}

.light-green-text.text-lighten-5 {
color: #f1f8e9 !important;
}

.light-green.lighten-4 {
background-color: #dcedc8 !important;
}

.light-green-text.text-lighten-4 {
color: #dcedc8 !important;
}

.light-green.lighten-3 {
background-color: #c5e1a5 !important;
}

.light-green-text.text-lighten-3 {
color: #c5e1a5 !important;
}

.light-green.lighten-2 {
background-color: #aed581 !important;
}

.light-green-text.text-lighten-2 {
color: #aed581 !important;
}

.light-green.lighten-1 {
background-color: #9ccc65 !important;
}

.light-green-text.text-lighten-1 {
color: #9ccc65 !important;
}

.light-green {
background-color: #8bc34a !important;
}

.light-green-text {
color: #8bc34a !important;
}

.light-green.darken-1 {
background-color: #7cb342 !important;
}

.light-green-text.text-darken-1 {
color: #7cb342 !important;
}

.light-green.darken-2 {
background-color: #689f38 !important;
}

.light-green-text.text-darken-2 {
color: #689f38 !important;
}

.light-green.darken-3 {
background-color: #558b2f !important;
}

.light-green-text.text-darken-3 {
color: #558b2f !important;
}

.light-green.darken-4 {
background-color: #33691e !important;
}

.light-green-text.text-darken-4 {
color: #33691e !important;
}

.light-green.accent-1 {
background-color: #ccff90 !important;
}

.light-green-text.text-accent-1 {
color: #ccff90 !important;
}

.light-green.accent-2 {
background-color: #b2ff59 !important;
}

.light-green-text.text-accent-2 {
color: #b2ff59 !important;
}

.light-green.accent-3 {
background-color: #76ff03 !important;
}

.light-green-text.text-accent-3 {
color: #76ff03 !important;
}

.light-green.accent-4 {
background-color: #64dd17 !important;
}

.light-green-text.text-accent-4 {
color: #64dd17 !important;
}

.lime.lighten-5 {
background-color: #f9fbe7 !important;
}

.lime-text.text-lighten-5 {
color: #f9fbe7 !important;
}

.lime.lighten-4 {
background-color: #f0f4c3 !important;
}

.lime-text.text-lighten-4 {
color: #f0f4c3 !important;
}

.lime.lighten-3 {
background-color: #e6ee9c !important;
}

.lime-text.text-lighten-3 {
color: #e6ee9c !important;
}

.lime.lighten-2 {
background-color: #dce775 !important;
}

.lime-text.text-lighten-2 {
color: #dce775 !important;
}

.lime.lighten-1 {
background-color: #d4e157 !important;
}

.lime-text.text-lighten-1 {
color: #d4e157 !important;
}

.lime {
background-color: #cddc39 !important;
}

.lime-text {
color: #cddc39 !important;
}

.lime.darken-1 {
background-color: #c0ca33 !important;
}

.lime-text.text-darken-1 {
color: #c0ca33 !important;
}

.lime.darken-2 {
background-color: #afb42b !important;
}

.lime-text.text-darken-2 {
color: #afb42b !important;
}

.lime.darken-3 {
background-color: #9e9d24 !important;
}

.lime-text.text-darken-3 {
color: #9e9d24 !important;
}

.lime.darken-4 {
background-color: #827717 !important;
}

.lime-text.text-darken-4 {
color: #827717 !important;
}

.lime.accent-1 {
background-color: #f4ff81 !important;
}

.lime-text.text-accent-1 {
color: #f4ff81 !important;
}

.lime.accent-2 {
background-color: #eeff41 !important;
}

.lime-text.text-accent-2 {
color: #eeff41 !important;
}

.lime.accent-3 {
background-color: #c6ff00 !important;
}

.lime-text.text-accent-3 {
color: #c6ff00 !important;
}

.lime.accent-4 {
background-color: #aeea00 !important;
}

.lime-text.text-accent-4 {
color: #aeea00 !important;
}

.yellow.lighten-5 {
background-color: #fffde7 !important;
}

.yellow-text.text-lighten-5 {
color: #fffde7 !important;
}

.yellow.lighten-4 {
background-color: #fff9c4 !important;
}

.yellow-text.text-lighten-4 {
color: #fff9c4 !important;
}

.yellow.lighten-3 {
background-color: #fff59d !important;
}

.yellow-text.text-lighten-3 {
color: #fff59d !important;
}

.yellow.lighten-2 {
background-color: #fff176 !important;
}

.yellow-text.text-lighten-2 {
color: #fff176 !important;
}

.yellow.lighten-1 {
background-color: #ffee58 !important;
}

.yellow-text.text-lighten-1 {
color: #ffee58 !important;
}

.yellow {
background-color: #ffeb3b !important;
}

.yellow-text {
color: #ffeb3b !important;
}

.yellow.darken-1 {
background-color: #fdd835 !important;
}

.yellow-text.text-darken-1 {
color: #fdd835 !important;
}

.yellow.darken-2 {
background-color: #fbc02d !important;
}

.yellow-text.text-darken-2 {
color: #fbc02d !important;
}

.yellow.darken-3 {
background-color: #f9a825 !important;
}

.yellow-text.text-darken-3 {
color: #f9a825 !important;
}

.yellow.darken-4 {
background-color: #f57f17 !important;
}

.yellow-text.text-darken-4 {
color: #f57f17 !important;
}

.yellow.accent-1 {
background-color: #ffff8d !important;
}

.yellow-text.text-accent-1 {
color: #ffff8d !important;
}

.yellow.accent-2 {
background-color: #ffff00 !important;
}

.yellow-text.text-accent-2 {
color: #ffff00 !important;
}

.yellow.accent-3 {
background-color: #ffea00 !important;
}

.yellow-text.text-accent-3 {
color: #ffea00 !important;
}

.yellow.accent-4 {
background-color: #ffd600 !important;
}

.yellow-text.text-accent-4 {
color: #ffd600 !important;
}

.amber.lighten-5 {
background-color: #fff8e1 !important;
}

.amber-text.text-lighten-5 {
color: #fff8e1 !important;
}

.amber.lighten-4 {
background-color: #ffecb3 !important;
}

.amber-text.text-lighten-4 {
color: #ffecb3 !important;
}

.amber.lighten-3 {
background-color: #ffe082 !important;
}

.amber-text.text-lighten-3 {
color: #ffe082 !important;
}

.amber.lighten-2 {
background-color: #ffd54f !important;
}

.amber-text.text-lighten-2 {
color: #ffd54f !important;
}

.amber.lighten-1 {
background-color: #ffca28 !important;
}

.amber-text.text-lighten-1 {
color: #ffca28 !important;
}

.amber {
background-color: #ffc107 !important;
}

.amber-text {
color: #ffc107 !important;
}

.amber.darken-1 {
background-color: #ffb300 !important;
}

.amber-text.text-darken-1 {
color: #ffb300 !important;
}

.amber.darken-2 {
background-color: #ffa000 !important;
}

.amber-text.text-darken-2 {
color: #ffa000 !important;
}

.amber.darken-3 {
background-color: #ff8f00 !important;
}

.amber-text.text-darken-3 {
color: #ff8f00 !important;
}

.amber.darken-4 {
background-color: #ff6f00 !important;
}

.amber-text.text-darken-4 {
color: #ff6f00 !important;
}

.amber.accent-1 {
background-color: #ffe57f !important;
}

.amber-text.text-accent-1 {
color: #ffe57f !important;
}

.amber.accent-2 {
background-color: #ffd740 !important;
}

.amber-text.text-accent-2 {
color: #ffd740 !important;
}

.amber.accent-3 {
background-color: #ffc400 !important;
}

.amber-text.text-accent-3 {
color: #ffc400 !important;
}

.amber.accent-4 {
background-color: #ffab00 !important;
}

.amber-text.text-accent-4 {
color: #ffab00 !important;
}

.orange.lighten-5 {
background-color: #fff3e0 !important;
}

.orange-text.text-lighten-5 {
color: #fff3e0 !important;
}

.orange.lighten-4 {
background-color: #ffe0b2 !important;
}

.orange-text.text-lighten-4 {
color: #ffe0b2 !important;
}

.orange.lighten-3 {
background-color: #ffcc80 !important;
}

.orange-text.text-lighten-3 {
color: #ffcc80 !important;
}

.orange.lighten-2 {
background-color: #ffb74d !important;
}

.orange-text.text-lighten-2 {
color: #ffb74d !important;
}

.orange.lighten-1 {
background-color: #ffa726 !important;
}

.orange-text.text-lighten-1 {
color: #ffa726 !important;
}

.orange {
background-color: #ff9800 !important;
}

.orange-text {
color: #ff9800 !important;
}

.orange.darken-1 {
background-color: #fb8c00 !important;
}

.orange-text.text-darken-1 {
color: #fb8c00 !important;
}

.orange.darken-2 {
background-color: #f57c00 !important;
}

.orange-text.text-darken-2 {
color: #f57c00 !important;
}

.orange.darken-3 {
background-color: #ef6c00 !important;
}

.orange-text.text-darken-3 {
color: #ef6c00 !important;
}

.orange.darken-4 {
background-color: #e65100 !important;
}

.orange-text.text-darken-4 {
color: #e65100 !important;
}

.orange.accent-1 {
background-color: #ffd180 !important;
}

.orange-text.text-accent-1 {
color: #ffd180 !important;
}

.orange.accent-2 {
background-color: #ffab40 !important;
}

.orange-text.text-accent-2 {
color: #ffab40 !important;
}

.orange.accent-3 {
background-color: #ff9100 !important;
}

.orange-text.text-accent-3 {
color: #ff9100 !important;
}

.orange.accent-4 {
background-color: #ff6d00 !important;
}

.orange-text.text-accent-4 {
color: #ff6d00 !important;
}

.deep-orange.lighten-5 {
background-color: #fbe9e7 !important;
}

.deep-orange-text.text-lighten-5 {
color: #fbe9e7 !important;
}

.deep-orange.lighten-4 {
background-color: #ffccbc !important;
}

.deep-orange-text.text-lighten-4 {
color: #ffccbc !important;
}

.deep-orange.lighten-3 {
background-color: #ffab91 !important;
}

.deep-orange-text.text-lighten-3 {
color: #ffab91 !important;
}

.deep-orange.lighten-2 {
background-color: #ff8a65 !important;
}

.deep-orange-text.text-lighten-2 {
color: #ff8a65 !important;
}

.deep-orange.lighten-1 {
background-color: #ff7043 !important;
}

.deep-orange-text.text-lighten-1 {
color: #ff7043 !important;
}

.deep-orange {
background-color: #ff5722 !important;
}

.deep-orange-text {
color: #ff5722 !important;
}

.deep-orange.darken-1 {
background-color: #f4511e !important;
}

.deep-orange-text.text-darken-1 {
color: #f4511e !important;
}

.deep-orange.darken-2 {
background-color: #e64a19 !important;
}

.deep-orange-text.text-darken-2 {
color: #e64a19 !important;
}

.deep-orange.darken-3 {
background-color: #d84315 !important;
}

.deep-orange-text.text-darken-3 {
color: #d84315 !important;
}

.deep-orange.darken-4 {
background-color: #bf360c !important;
}

.deep-orange-text.text-darken-4 {
color: #bf360c !important;
}

.deep-orange.accent-1 {
background-color: #ff9e80 !important;
}

.deep-orange-text.text-accent-1 {
color: #ff9e80 !important;
}

.deep-orange.accent-2 {
background-color: #ff6e40 !important;
}

.deep-orange-text.text-accent-2 {
color: #ff6e40 !important;
}

.deep-orange.accent-3 {
background-color: #ff3d00 !important;
}

.deep-orange-text.text-accent-3 {
color: #ff3d00 !important;
}

.deep-orange.accent-4 {
background-color: #dd2c00 !important;
}

.deep-orange-text.text-accent-4 {
color: #dd2c00 !important;
}

.brown.lighten-5 {
background-color: #efebe9 !important;
}

.brown-text.text-lighten-5 {
color: #efebe9 !important;
}

.brown.lighten-4 {
background-color: #d7ccc8 !important;
}

.brown-text.text-lighten-4 {
color: #d7ccc8 !important;
}

.brown.lighten-3 {
background-color: #bcaaa4 !important;
}

.brown-text.text-lighten-3 {
color: #bcaaa4 !important;
}

.brown.lighten-2 {
background-color: #a1887f !important;
}

.brown-text.text-lighten-2 {
color: #a1887f !important;
}

.brown.lighten-1 {
background-color: #8d6e63 !important;
}

.brown-text.text-lighten-1 {
color: #8d6e63 !important;
}

.brown {
background-color: #795548 !important;
}

.brown-text {
color: #795548 !important;
}

.brown.darken-1 {
background-color: #6d4c41 !important;
}

.brown-text.text-darken-1 {
color: #6d4c41 !important;
}

.brown.darken-2 {
background-color: #5d4037 !important;
}

.brown-text.text-darken-2 {
color: #5d4037 !important;
}

.brown.darken-3 {
background-color: #4e342e !important;
}

.brown-text.text-darken-3 {
color: #4e342e !important;
}

.brown.darken-4 {
background-color: #3e2723 !important;
}

.brown-text.text-darken-4 {
color: #3e2723 !important;
}

.blue-grey.lighten-5 {
background-color: #eceff1 !important;
}

.blue-grey-text.text-lighten-5 {
color: #eceff1 !important;
}

.blue-grey.lighten-4 {
background-color: #cfd8dc !important;
}

.blue-grey-text.text-lighten-4 {
color: #cfd8dc !important;
}

.blue-grey.lighten-3 {
background-color: #b0bec5 !important;
}

.blue-grey-text.text-lighten-3 {
color: #b0bec5 !important;
}

.blue-grey.lighten-2 {
background-color: #90a4ae !important;
}

.blue-grey-text.text-lighten-2 {
color: #90a4ae !important;
}

.blue-grey.lighten-1 {
background-color: #78909c !important;
}

.blue-grey-text.text-lighten-1 {
color: #78909c !important;
}

.blue-grey {
background-color: #607d8b !important;
}

.blue-grey-text {
color: #607d8b !important;
}

.blue-grey.darken-1 {
background-color: #546e7a !important;
}

.blue-grey-text.text-darken-1 {
color: #546e7a !important;
}

.blue-grey.darken-2 {
background-color: #455a64 !important;
}

.blue-grey-text.text-darken-2 {
color: #455a64 !important;
}

.blue-grey.darken-3 {
background-color: #37474f !important;
}

.blue-grey-text.text-darken-3 {
color: #37474f !important;
}

.blue-grey.darken-4 {
background-color: #263238 !important;
}

.blue-grey-text.text-darken-4 {
color: #263238 !important;
}

.grey.lighten-5 {
background-color: #fafafa !important;
}

.grey-text.text-lighten-5 {
color: #fafafa !important;
}

.grey.lighten-4 {
background-color: #f5f5f5 !important;
}

.grey-text.text-lighten-4 {
color: #f5f5f5 !important;
}

.grey.lighten-3 {
background-color: #eeeeee !important;
}

.grey-text.text-lighten-3 {
color: #eeeeee !important;
}

.grey.lighten-2 {
background-color: #e0e0e0 !important;
}

.grey-text.text-lighten-2 {
color: #e0e0e0 !important;
}

.grey.lighten-1 {
background-color: #bdbdbd !important;
}

.grey-text.text-lighten-1 {
color: #bdbdbd !important;
}

.grey {
background-color: #9e9e9e !important;
}

.grey-text {
color: #9e9e9e !important;
}

.grey.darken-1 {
background-color: #757575 !important;
}

.grey-text.text-darken-1 {
color: #757575 !important;
}

.grey.darken-2 {
background-color: #616161 !important;
}

.grey-text.text-darken-2 {
color: #616161 !important;
}

.grey.darken-3 {
background-color: #424242 !important;
}

.grey-text.text-darken-3 {
color: #424242 !important;
}

.grey.darken-4 {
background-color: #212121 !important;
}

.grey-text.text-darken-4 {
color: #212121 !important;
}

.shades.black {
background-color: #000000 !important;
}

.shades-text.text-black {
color: #000000 !important;
}

.shades.white {
background-color: #FFFFFF !important;
}

.shades-text.text-white {
color: #FFFFFF !important;
}

.shades.transparent {
background-color: transparent !important;
}

.shades-text.text-transparent {
color: transparent !important;
}

.black {
background-color: #000000 !important;
}

.black-text {
color: #000000 !important;
}

.white {
background-color: #FFFFFF !important;
}

.white-text {
color: #FFFFFF !important;
}

.transparent {
background-color: transparent !important;
}

.transparent-text {
color: transparent !important;
}

.danger-color {
background-color: #ff4444;
}

.danger-color-dark {
background-color: #CC0000;
}

.warning-color {
background-color: #ffbb33;
}

.warning-color-dark {
background-color: #FF8800;
}

.success-color {
background-color: #99cc00;
}

.success-color-dark {
background-color: #669900;
}

.info-color {
background-color: #33b5e5;
}

.info-color-dark {
background-color: #0099CC;
}

.default-color {
background-color: #2BBBAD;
}

.default-color-dark {
background-color: #00695c;
}

.primary-color {
background-color: #4285F4;
}

.primary-color-dark {
background-color: #0d47a1;
}

.secondary-color {
background-color: #aa66cc;
}

.secondary-color-dark {
background-color: #9933CC;
}

.elegant-color {
background-color: #2E2E2E;
}

.elegant-color-dark {
background-color: #212121;
}

.stylish-color {
background-color: #4B515D;
}

.stylish-color-dark {
background-color: #3E4551;
}

/*********************
Variables
**********************/
/*** Tooltip ***/
/* ANIMATION */
/*** Colors ***/
/*** Badges ***/
/*** Buttons ***/
/*** Cards ***/
/*** Collapsible ***/
/*** Dropdown ***/
/*** Fonts ***/
/*** Forms ***/
/*** Global ***/
/*** Navbar ***/
/*** SideNav ***/
/*** Photo Slider ***/
/*** Tabs ***/
/*** Tables ***/
/*** Toasts ***/
/*** Typography ***/
/*** Collections ***/
/* Progress Bar */
/*********************
Normalize
**********************/
/*! normalize.css v3.0.2 | MIT License | git.io/normalize */
/**
* 1. Set default font family to sans-serif.
* 2. Prevent iOS text size adjust after orientation change, without disabling
*    user zoom.
*/
html {
font-family: sans-serif;
/* 1 */
-ms-text-size-adjust: 100%;
/* 2 */
-webkit-text-size-adjust: 100%;
/* 2 */
}

/**
* Remove default margin.
*/
body {
margin: 0;
}

/* HTML5 display definitions
 ========================================================================== */
/**
* Correct `block` display not defined for any HTML5 element in IE 8/9.
* Correct `block` display not defined for `details` or `summary` in IE 10/11
* and Firefox.
* Correct `block` display not defined for `main` in IE 11.
*/
article,
aside,
details,
figcaption,
figure,
footer,
header,
hgroup,
main,
menu,
nav,
section,
summary {
display: block;
}

/**
* 1. Correct `inline-block` display not defined in IE 8/9.
* 2. Normalize vertical alignment of `progress` in Chrome, Firefox, and Opera.
*/
audio,
canvas,
progress,
video {
display: inline-block;
/* 1 */
vertical-align: baseline;
/* 2 */
}

/**
* Prevent modern browsers from displaying `audio` without controls.
* Remove excess height in iOS 5 devices.
*/
audio:not([controls]) {
display: none;
height: 0;
}

/**
* Address `[hidden]` styling not present in IE 8/9/10.
* Hide the `template` element in IE 8/9/11, Safari, and Firefox < 22.
*/
[hidden],
template {
display: none;
}

/* Links
 ========================================================================== */
/**
* Remove the gray background color from active links in IE 10.
*/
a {
background-color: transparent;
}

/**
* Improve readability when focused and also mouse hovered in all browsers.
*/
a:active,
a:hover {
outline: 0;
}

/* Text-level semantics
 ========================================================================== */
/**
* Address styling not present in IE 8/9/10/11, Safari, and Chrome.
*/
abbr[title] {
border-bottom: 1px dotted;
}

/**
* Address style set to `bolder` in Firefox 4+, Safari, and Chrome.
*/
b,
strong {
font-weight: bold;
}

/**
* Address styling not present in Safari and Chrome.
*/
dfn {
font-style: italic;
}

/**
* Address variable `h1` font-size and margin within `section` and `article`
* contexts in Firefox 4+, Safari, and Chrome.
*/
h1 {
font-size: 2em;
margin: 0.67em 0;
}

/**
* Address styling not present in IE 8/9.
*/
mark {
background: #ff0;
color: #000;
}

/**
* Address inconsistent and variable font size in all browsers.
*/
small {
font-size: 80%;
}

/**
* Prevent `sub` and `sup` affecting `line-height` in all browsers.
*/
sub,
sup {
font-size: 75%;
line-height: 0;
position: relative;
vertical-align: baseline;
}

sup {
top: -0.5em;
}

sub {
bottom: -0.25em;
}

/* Embedded content
 ========================================================================== */
/**
* Remove border when inside `a` element in IE 8/9/10.
*/
img {
border: 0;
}

/**
* Correct overflow not hidden in IE 9/10/11.
*/
svg:not(:root) {
overflow: hidden;
}

/* Grouping content
 ========================================================================== */
/**
* Address margin not present in IE 8/9 and Safari.
*/
figure {
margin: 1em 40px;
}

/**
* Address differences between Firefox and other browsers.
*/
hr {
-moz-box-sizing: content-box;
box-sizing: content-box;
height: 0;
}

/**
* Contain overflow in all browsers.
*/
pre {
overflow: auto;
}

/**
* Address odd `em`-unit font size rendering in all browsers.
*/
code,
kbd,
pre,
samp {
font-family: monospace, monospace;
font-size: 1em;
}

/* Forms
 ========================================================================== */
/**
* Known limitation: by default, Chrome and Safari on OS X allow very limited
* styling of `select`, unless a `border` property is set.
*/
/**
* 1. Correct color not being inherited.
*    Known issue: affects color of disabled elements.
* 2. Correct font properties not being inherited.
* 3. Address margins set differently in Firefox 4+, Safari, and Chrome.
*/
button,
input,
optgroup,
select,
textarea {
color: inherit;
/* 1 */
font: inherit;
/* 2 */
margin: 0;
/* 3 */
}

/**
* Address `overflow` set to `hidden` in IE 8/9/10/11.
*/
button {
overflow: visible;
}

/**
* Address inconsistent `text-transform` inheritance for `button` and `select`.
* All other form control elements do not inherit `text-transform` values.
* Correct `button` style inheritance in Firefox, IE 8/9/10/11, and Opera.
* Correct `select` style inheritance in Firefox.
*/
button,
select {
text-transform: none;
}

/**
* 1. Avoid the WebKit bug in Android 4.0.* where (2) destroys native `audio`
*    and `video` controls.
* 2. Correct inability to style clickable `input` types in iOS.
* 3. Improve usability and consistency of cursor style between image-type
*    `input` and others.
*/
/* 1 */
html input[type="button"],
button,
input[type="reset"],
input[type="submit"] {
-webkit-appearance: button;
/* 2 */
cursor: pointer;
/* 3 */
}

/**
* Re-set default cursor for disabled elements.
*/
button[disabled],
html input[disabled] {
cursor: default;
}

/**
* Remove inner padding and border in Firefox 4+.
*/
button::-moz-focus-inner,
input::-moz-focus-inner {
border: 0;
padding: 0;
}

/**
* Address Firefox 4+ setting `line-height` on `input` using `!important` in
* the UA stylesheet.
*/
input {
line-height: normal;
}

/**
* It's recommended that you don't attempt to style these elements.
* Firefox's implementation doesn't respect box-sizing, padding, or width.
*
* 1. Address box sizing set to `content-box` in IE 8/9/10.
* 2. Remove excess padding in IE 8/9/10.
*/
input[type="checkbox"],
input[type="radio"] {
box-sizing: border-box;
/* 1 */
padding: 0;
/* 2 */
}

/**
* Fix the cursor style for Chrome's increment/decrement buttons. For certain
* `font-size` values of the `input`, it causes the cursor style of the
* decrement button to change from `default` to `text`.
*/
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
height: auto;
}

/**
* 1. Address `appearance` set to `searchfield` in Safari and Chrome.
* 2. Address `box-sizing` set to `border-box` in Safari and Chrome
*    (include `-moz` to future-proof).
*/
input[type="search"] {
-webkit-appearance: textfield;
/* 1 */
-moz-box-sizing: content-box;
-webkit-box-sizing: content-box;
/* 2 */
box-sizing: content-box;
}

/**
* Remove inner padding and search cancel button in Safari and Chrome on OS X.
* Safari (but not Chrome) clips the cancel button when the search input has
* padding (and `textfield` appearance).
*/
input[type="search"]::-webkit-search-cancel-button,
input[type="search"]::-webkit-search-decoration {
-webkit-appearance: none;
}

/**
* Define consistent border, margin, and padding.
*/
fieldset {
border: 1px solid #c0c0c0;
margin: 0 2px;
padding: 0.35em 0.625em 0.75em;
}

/**
* 1. Correct `color` not being inherited in IE 8/9/10/11.
* 2. Remove padding so people aren't caught out if they zero out fieldsets.
*/
legend {
border: 0;
/* 1 */
padding: 0;
/* 2 */
}

/**
* Remove default vertical scrollbar in IE 8/9/10/11.
*/
textarea {
overflow: auto;
}

/**
* Don't inherit the `font-weight` (applied by a rule above).
* NOTE: the default cannot safely be changed in Chrome and Safari on OS X.
*/
optgroup {
font-weight: bold;
}

/* Tables
 ========================================================================== */
/**
* Remove most spacing between table cells.
*/
table {
border-collapse: collapse;
border-spacing: 0;
}

td,
th {
padding: 0;
}

/*********************
General classes
**********************/
body {
font-family: Roboto, sans-serif;
}

span.badge-md {
min-width: 3rem;
padding: 0 6px;
text-align: center;
font-size: 1rem;
line-height: inherit;
color: #757575;
position: absolute;
right: 15px;
-webkit-box-sizing: border-box;
-moz-box-sizing: border-box;
box-sizing: border-box;
}

span.badge-md.new {
font-weight: 300;
font-size: 0.8rem;
color: #fff;
background-color: #4285F4;
border-radius: 2px;
}

span.badge-md.new:after {
content: " new";
}

a {
color: #039be5;
text-decoration: none;
-webkit-tap-highlight-color: transparent;
}

a:hover,
a:focus {
text-decoration: none;
}

ul {
padding: 0;
list-style-type: none;
}

ul li {
list-style-type: none;
}

i {
line-height: inherit;
}

i.left {
float: left;
margin-right: 10px;
}

i.right {
float: right;
margin-left: 10px;
}

i.tiny {
font-size: 1rem;
}

i.small {
font-size: 2rem;
}

i.medium {
font-size: 4rem;
}

i.large {
font-size: 6rem;
}

.collection {
margin: 0.5rem 0 1rem 0;
border: 1px solid #e0e0e0;
border-radius: 2px;
overflow: hidden;
position: relative;
}

.collection .collection-item {
background-color: #fff;
line-height: 1.5rem;
padding: 10px 20px;
margin: 0;
border-bottom: 1px solid #e0e0e0;
}

.collection .collection-item.avatar {
min-height: 84px;
padding-left: 72px;
position: relative;
}

.collection .collection-item.avatar .circle {
position: absolute;
width: 42px;
height: 42px;
overflow: hidden;
left: 15px;
display: inline-block;
vertical-align: middle;
}

.collection .collection-item.avatar i.circle {
font-size: 18px;
line-height: 42px;
color: #fff;
background-color: #999;
text-align: center;
}

.collection .collection-item.avatar .title {
font-size: 16px;
}

.collection .collection-item.avatar p {
margin: 0;
}

.collection .collection-item.avatar .secondary-content {
position: absolute;
top: 16px;
right: 16px;
}

.collection .collection-item:last-child {
border-bottom: none;
}

.collection .collection-item.active {
background-color: #4285F4;
color: white;
}

.collection a.collection-item {
display: block;
-webkit-transition: 0.25s;
-moz-transition: 0.25s;
-o-transition: 0.25s;
-ms-transition: 0.25s;
transition: 0.25s;
color: #4285F4;
}

.collection a.collection-item:not(.active):hover {
background-color: #ddd;
}

.collection.with-header .collection-header {
background-color: #fff;
border-bottom: 1px solid #e0e0e0;
padding: 10px 20px;
}

.collection.with-header .collection-item {
padding-left: 30px;
}

.collection.with-header .collection-item.avatar {
padding-left: 72px;
}

.secondary-content {
float: right;
color: #4285F4;
}

footer.page-footer {
margin-top: 20px;
padding-top: 20px;
background-color: #4285F4;
}

footer.page-footer .footer-copyright {
overflow: hidden;
height: 50px;
line-height: 50px;
color: rgba(255, 255, 255, 0.8);
background-color: rgba(51, 51, 51, 0.08);
}

.section-white {
background-color: #fff;
color: #666666;
text-align: center;
padding: 1.5em 0;
}

.section-white h3 {
margin-bottom: 1.1em;
margin-top: 1.1em;
}

.section-dark {
background-color: #212121;
color: #fff;
text-align: center;
padding: 2.8em 0;
}

.section-dark h3 {
margin-bottom: 1.1em;
margin-top: 1.1em;
}

/*********************
Roboto font
**********************/
@font-face {
font-family: "Roboto";
src: url("../font/roboto/Roboto-Thin.woff2") format("woff2"), url("../font/roboto/Roboto-Thin.woff") format("woff"), url("../font/roboto/Roboto-Thin.ttf") format("truetype");
font-weight: 200;
}

@font-face {
font-family: "Roboto";
src: url("../font/roboto/Roboto-Light.woff2") format("woff2"), url("../font/roboto/Roboto-Light.woff") format("woff"), url("../font/roboto/Roboto-Light.ttf") format("truetype");
font-weight: 300;
}

@font-face {
font-family: "Roboto";
src: url("../font/roboto/Roboto-Regular.woff2") format("woff2"), url("../font/roboto/Roboto-Regular.woff") format("woff"), url("../font/roboto/Roboto-Regular.ttf") format("truetype");
font-weight: 400;
}

@font-face {
font-family: "Roboto";
src: url("../font/roboto/Roboto-Medium.woff2") format("woff2"), url("../font/roboto/Roboto-Medium.woff") format("woff"), url("../font/roboto/Roboto-Medium.ttf") format("truetype");
font-weight: 500;
}

@font-face {
font-family: "Roboto";
src: url("../font/roboto/Roboto-Bold.woff2") format("woff2"), url("../font/roboto/Roboto-Bold.woff") format("woff"), url("../font/roboto/Roboto-Bold.ttf") format("truetype");
font-weight: 700;
}

/*********************
Buttons
**********************/
.btn-flat {
background-color: transparent;
position: relative;
padding: 8px 30px;
border: none;
margin: 10px;
text-transform: uppercase;
text-decoration: none;
outline: none !important;
}

.btn-flat:focus {
background-color: transparent;
}

.btn {
line-height: 31px;
position: relative;
padding: 5px 22px;
border: 0;
margin: 10px;
cursor: pointer;
border-radius: 2px;
text-transform: uppercase;
text-decoration: none;
outline: none !important;
-webkit-transition: 0.2s ease-out;
-moz-transition: 0.2s ease-out;
-o-transition: 0.2s ease-out;
-ms-transition: 0.2s ease-out;
transition: 0.2s ease-out;
}

.btn i,
.btn-flat i {
font-size: 1.3rem;
line-height: inherit;
}

.btn-floating {
display: inline-block;
color: #fff;
position: relative;
overflow: hidden;
z-index: 1;
width: 37px;
height: 37px;
line-height: 37px;
padding: 0;
background-color: #aa66cc;
border-radius: 50%;
transition: .3s;
cursor: pointer;
vertical-align: middle;
margin: 10px;
}

.btn-floating i {
width: inherit;
display: inline-block;
text-align: center;
color: #fff;
font-size: 1.6rem;
line-height: 37px;
}

.btn-floating:before {
border-radius: 0;
}

.btn-floating.btn-large {
width: 55.5px;
height: 55.5px;
}

.btn-floating.btn-large i {
line-height: 55.5px;
}

button.btn-floating {
border: none;
}

.btn .badge {
margin-left: 7px;
}

.btn-default {
color: #fff;
background-color: #2BBBAD;
}

.btn-default:hover,
.btn-default:focus {
background-color: #30cfc0 !important;
color: #fff !important;
}

.btn-primary {
background-color: #4285F4;
}

.btn-primary:hover,
.btn-primary:focus {
background-color: #5a95f5 !important;
color: #fff;
}

.btn-success {
background-color: #00c853;
}

.btn-success:hover,
.btn-success:focus {
background-color: #00e25e !important;
color: #fff;
}

.btn-info {
background-color: #03A9F4;
}

.btn-info:hover,
.btn-info:focus {
background-color: #14b4fc !important;
color: #fff;
}

.btn-warning {
background-color: #FF5722;
}

.btn-warning:hover,
.btn-warning:focus {
background-color: #ff6a3c !important;
color: #fff;
}

.btn-danger {
background-color: #d32f2f;
}

.btn-danger:hover,
.btn-danger:focus {
background-color: #d74444 !important;
color: #fff;
}

.btn-link {
background-color: transparent;
color: #000;
}

.btn-link:hover {
background-color: transparent;
}

.btn-link:focus {
background-color: transparent;
}

.btn-xlg {
padding: 18px 24px;
font-size: 21px;
line-height: 1.33333;
}

.btn-lg {
padding: 14px 20px;
font-size: 18px;
line-height: 1.33333;
}

.btn-sm {
padding: 5px 10px;
font-size: 12px;
line-height: 1.5;
}

.btn-xs {
padding: 1px 5px;
font-size: 12px;
line-height: 1.5;
}

.btn-material-red {
background-color: ("lighten-5": #FFEBEE, "lighten-4": #FFCDD2, "lighten-3": #EF9A9A, "lighten-2": #E57373, "lighten-1": #EF5350, "base": #F44336, "darken-1": #E53935, "darken-2": #D32F2F, "darken-3": #C62828, "darken-4": #B71C1C, "accent-1": #FF8A80, "accent-2": #FF5252, "accent-3": #FF1744, "accent-4": #D50000);
}

.btn-material-pink {
background-color: ("lighten-5": #fce4ec, "lighten-4": #f8bbd0, "lighten-3": #f48fb1, "lighten-2": #f06292, "lighten-1": #ec407a, "base": #e91e63, "darken-1": #d81b60, "darken-2": #c2185b, "darken-3": #ad1457, "darken-4": #880e4f, "accent-1": #ff80ab, "accent-2": #ff4081, "accent-3": #f50057, "accent-4": #c51162);
}

.btn-material-purple {
background-color: ("lighten-5": #f3e5f5, "lighten-4": #e1bee7, "lighten-3": #ce93d8, "lighten-2": #ba68c8, "lighten-1": #ab47bc, "base": #9c27b0, "darken-1": #8e24aa, "darken-2": #7b1fa2, "darken-3": #6a1b9a, "darken-4": #4a148c, "accent-1": #ea80fc, "accent-2": #e040fb, "accent-3": #d500f9, "accent-4": #aa00ff);
}

.btn-material-deeppurple {
background-color: #673AB7;
}

.btn-material-indigo {
background-color: ("lighten-5": #e8eaf6, "lighten-4": #c5cae9, "lighten-3": #9fa8da, "lighten-2": #7986cb, "lighten-1": #5c6bc0, "base": #3f51b5, "darken-1": #3949ab, "darken-2": #303f9f, "darken-3": #283593, "darken-4": #1a237e, "accent-1": #8c9eff, "accent-2": #536dfe, "accent-3": #3d5afe, "accent-4": #304ffe);
}

.btn-material-lightblue {
background-color: #03A9F4;
}

.btn-material-cyan {
background-color: ("lighten-5": #e0f7fa, "lighten-4": #b2ebf2, "lighten-3": #80deea, "lighten-2": #4dd0e1, "lighten-1": #26c6da, "base": #00bcd4, "darken-1": #00acc1, "darken-2": #0097a7, "darken-3": #00838f, "darken-4": #006064, "accent-1": #84ffff, "accent-2": #18ffff, "accent-3": #00e5ff, "accent-4": #00b8d4);
}

.btn-material-teal {
background-color: ("lighten-5": #e0f2f1, "lighten-4": #b2dfdb, "lighten-3": #80cbc4, "lighten-2": #4db6ac, "lighten-1": #26a69a, "base": #009688, "darken-1": #00897b, "darken-2": #00796b, "darken-3": #00695c, "darken-4": #004d40, "accent-1": #a7ffeb, "accent-2": #64ffda, "accent-3": #1de9b6, "accent-4": #00bfa5);
}

.btn-material-lightgreen {
background-color: #8BC34A;
}

.btn-material-lime {
background-color: ("lighten-5": #f9fbe7, "lighten-4": #f0f4c3, "lighten-3": #e6ee9c, "lighten-2": #dce775, "lighten-1": #d4e157, "base": #cddc39, "darken-1": #c0ca33, "darken-2": #afb42b, "darken-3": #9e9d24, "darken-4": #827717, "accent-1": #f4ff81, "accent-2": #eeff41, "accent-3": #c6ff00, "accent-4": #aeea00);
}

.btn-material-lightyellow {
background-color: #FFEB3B;
}

.btn-material-orange {
background-color: ("lighten-5": #fff3e0, "lighten-4": #ffe0b2, "lighten-3": #ffcc80, "lighten-2": #ffb74d, "lighten-1": #ffa726, "base": #ff9800, "darken-1": #fb8c00, "darken-2": #f57c00, "darken-3": #ef6c00, "darken-4": #e65100, "accent-1": #ffd180, "accent-2": #ffab40, "accent-3": #ff9100, "accent-4": #ff6d00);
}

.btn-material-deeporange {
background-color: #FF5722;
}

.btn-material-grey {
background-color: ("lighten-5": #fafafa, "lighten-4": #f5f5f5, "lighten-3": #eeeeee, "lighten-2": #e0e0e0, "lighten-1": #bdbdbd, "base": #9e9e9e, "darken-1": #757575, "darken-2": #616161, "darken-3": #424242, "darken-4": #212121);
}

.btn-material-bluegrey {
background-color: #607D8B;
}

.btn-material-brown {
background-color: ("lighten-5": #efebe9, "lighten-4": #d7ccc8, "lighten-3": #bcaaa4, "lighten-2": #a1887f, "lighten-1": #8d6e63, "base": #795548, "darken-1": #6d4c41, "darken-2": #5d4037, "darken-3": #4e342e, "darken-4": #3e2723);
}

.btn-material-lightgrey {
background-color: #ECECEC;
}

/*********************
Shadows
**********************/
.z-depth-0 {
box-shadow: none !important;
}

.z-depth-1, .btn, .btn-floating {
box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
}

.z-depth-1-half, .btn:hover, .btn-floating:hover {
box-shadow: 0 5px 11px 0 rgba(0, 0, 0, 0.18), 0 4px 15px 0 rgba(0, 0, 0, 0.15);
}

.z-depth-2 {
box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}

.z-depth-3 {
box-shadow: 0 12px 15px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
}

.z-depth-4 {
box-shadow: 0 16px 28px 0 rgba(0, 0, 0, 0.22), 0 25px 55px 0 rgba(0, 0, 0, 0.21);
}

.z-depth-5 {
box-shadow: 0 27px 24px 0 rgba(0, 0, 0, 0.2), 0 40px 77px 0 rgba(0, 0, 0, 0.22);
}

.hoverable:hover {
transition: box-shadow 0.25s;
box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}

/*********************
Waves
**********************/
/*!
* Waves v0.6.0
* http://fian.my.id/Waves
*
* Copyright 2014 Alfiana E. Sibuea and other contributors
* Released under the MIT license
* https://github.com/fians/Waves/blob/master/LICENSE
*/
.waves-effect {
position: relative;
cursor: pointer;
display: inline-block;
overflow: hidden;
-webkit-user-select: none;
-moz-user-select: none;
-ms-user-select: none;
user-select: none;
-webkit-tap-highlight-color: transparent;
vertical-align: middle;
z-index: 1;
will-change: opacity, transform;
-webkit-transition: all 0.3s ease-out;
-moz-transition: all 0.3s ease-out;
-o-transition: all 0.3s ease-out;
-ms-transition: all 0.3s ease-out;
transition: all 0.3s ease-out;
}

.waves-effect .waves-ripple {
position: absolute;
border-radius: 50%;
width: 20px;
height: 20px;
margin-top: -10px;
margin-left: -10px;
opacity: 0;
background: rgba(0, 0, 0, 0.2);
-webkit-transition: all 0.7s ease-out;
-moz-transition: all 0.7s ease-out;
-o-transition: all 0.7s ease-out;
-ms-transition: all 0.7s ease-out;
transition: all 0.7s ease-out;
-webkit-transition-property: -webkit-transform, opacity;
-moz-transition-property: -moz-transform, opacity;
-o-transition-property: -o-transform, opacity;
transition-property: transform, opacity;
-webkit-transform: scale(0);
-moz-transform: scale(0);
-ms-transform: scale(0);
-o-transform: scale(0);
transform: scale(0);
pointer-events: none;
}

.waves-effect.waves-light .waves-ripple {
background-color: rgba(255, 255, 255, 0.45);
}

.waves-effect.waves-red .waves-ripple {
background-color: rgba(244, 67, 54, 0.7);
}

.waves-effect.waves-yellow .waves-ripple {
background-color: rgba(255, 235, 59, 0.7);
}

.waves-effect.waves-orange .waves-ripple {
background-color: rgba(255, 152, 0, 0.7);
}

.waves-effect.waves-purple .waves-ripple {
background-color: rgba(156, 39, 176, 0.7);
}

.waves-effect.waves-green .waves-ripple {
background-color: rgba(76, 175, 80, 0.7);
}

.waves-effect.waves-teal .waves-ripple {
background-color: rgba(0, 150, 136, 0.7);
}

.waves-notransition {
-webkit-transition: none !important;
-moz-transition: none !important;
-o-transition: none !important;
-ms-transition: none !important;
transition: none !important;
}

.waves-circle {
-webkit-transform: translateZ(0);
-moz-transform: translateZ(0);
-ms-transform: translateZ(0);
-o-transform: translateZ(0);
transform: translateZ(0);
-webkit-mask-image: -webkit-radial-gradient(circle, white 100%, black 100%);
}

.waves-input-wrapper {
border-radius: 0.2em;
vertical-align: bottom;
}

.waves-input-wrapper .waves-button-input {
position: relative;
top: 0;
left: 0;
z-index: 1;
}

.waves-circle {
text-align: center;
width: 2.5em;
height: 2.5em;
line-height: 2.5em;
border-radius: 50%;
-webkit-mask-image: none;
}

.waves-block {
display: block;
}

/* Firefox Bug: link not triggered */
a.waves-effect .waves-ripple {
z-index: -1;
}

/*********************
Media Query Classes
**********************/
@media only screen and (max-width: 600px) {
.center-on-small-only {
  text-align: center;
}
}

.no-margin {
margin: 0;
padding: 0;
}

.space-30 {
height: 30px;
}

.vcenter {
display: inline-block;
vertical-align: middle;
float: none;
}

.vertical-center {
margin: 0;
min-height: 100%;
/* Fallback for vh unit */
min-height: 100vh;
/* You might also want to use
                      'height' property instead.

                      Note that for percentage values of
                      'height' or 'min-height' properties,
                      the 'height' of the parent element
                      should be specified explicitly.

                      In this case the parent of '.vertical-center'
                      is the <body> element */
/* Make it a flex container */
display: -webkit-box;
display: -moz-box;
display: -ms-flexbox;
display: -webkit-flex;
display: flex;
/* Align the bootstrap's container vertically */
-webkit-box-align: center;
-webkit-align-items: center;
-moz-box-align: center;
-ms-flex-align: center;
align-items: center;
/* In legacy web browsers such as Firefox 9
   we need to specify the width of the flex container */
width: 100%;
/* Also 'margin: 0 auto' doesn't have any effect on flex items in such web browsers
   hence the bootstrap's container won't be aligned to the center anymore.

   Therefore, we should use the following declarations to get it centered again */
-webkit-box-pack: center;
-moz-box-pack: center;
-ms-flex-pack: center;
-webkit-justify-content: center;
justify-content: center;
}

</style>
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
width: 40rem;
height: 25rem;
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
.box_table:hover{
  background: none;
}
.box_table tr:hover{
  background: none;
}
.box_table td:hover{
  background: none;
}
</style>
