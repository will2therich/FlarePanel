<?php
// Kill session data
session_start();
session_destroy();

// Redirect to login page
header('Location: /Login/User/index.php');
exit(0);

?>
