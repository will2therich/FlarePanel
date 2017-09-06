<?php
// Kill session data
session_start();
session_destroy();

// Redirect to login page
header('Location: ../Login/Admin/index.php?out=1');
exit(0);

?>