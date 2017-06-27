<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION['gpx_userid']) || !isset($_SESSION['gpx_admin'])) die('Please login');

// $Plugins->do_action('home_top'); // Plugins

// Debug info

?>
<link rel="stylesheet" type="text/css" href="../themes/dd.css" />
<script type="text/javascript" src="../scripts/jquery.min.js"></script>

<div class="infobox" style="display:none;"></div>


<div class="container" style="color:white !important;font-size:15px;width:100%;">

  <header>
    <div class="fa fa-gear"></div>
    <div class="title">Site Settings</div>
  </header>

  <div class="content-wrapper" style="width:76%">
    <form id="SubuserForm" action="#" method="post">
      <?php
      $conn = mysqli_connect("localhost","root","flareservers","gamepaneltest");
        $MaintCheck = mysqli_query($conn,"SELECT
          config_value
          FROM configuration
          WHERE config_setting = 'maint_mode'
          ") or die ("Unable To Check Login Try Again Later");
          $maintmode = $MaintCheck->fetch_array();
          $maint_mode = $maintmode['config_value'];
      if ($maint_mode != 0) {
        echo("<button type='button' onclick='disablemaint();' class='btn btn-default waves-effect waves-light'>Disable Maintenance Mode (Users Will be able to access the site)</button>");
      }
      else{
        echo ("<button type='button' onclick='enablemaint();'  class='btn btn-default waves-effect waves-light'>Enable Maintenance Mode (Users Will be unable to access the site)</button>");
      }
      ?>
      </form>
      </select>
    </div>
  </div>
</div>



<!--

<form id="SubuserForm" action="#" method="post">
    <input  name="ServerID"  id="ServerID" value="" tabindex="5"  type="text">
    <input  name="UserID2"  id="UserID2" value="" tabindex="5"  type="text">
	<input type="submit" name="Update" id="update" value="Update" />
 </form> -->






 <script>


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


 </script>

<style media="screen">
@import url("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css");



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

</style>
