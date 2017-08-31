<?php
// Main GamePanelX Configuration File
$settings['db_host']      = ''; // No need to change this
$settings['db_name']      = ''; // Your database name
$settings['db_username']  = ''; // Your database username
$settings['db_password']  = ''; // Your database password
$settings['docroot']      = ''; // Set to the full path to your GamePanelX installation e.g. /home/me/public_html/gpx/
$settings['enc_key']      = ''; // No need to change this
$settings['debug']        = false;
$GLOBALS['mysqli'] = mysqli_connect($settings['db_host'],$settings['db_username'],$settings['db_password'],$settings['db_name']);

###################################

/* No need to edit these! */
if(!defined('DOCROOT'))
{
    define('DOCROOT', $settings['docroot']);
    define('GPXDEBUG', $settings['debug']);
}

date_default_timezone_set('US/Central');

if($settings['debug']) error_reporting(E_ALL);
else error_reporting(E_ERROR);

?>