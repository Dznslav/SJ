<?php
session_start(); 

// destroying session data
$_SESSION = array();

// destroying session
session_destroy();

// redirect to log/reg
header("Location: logreg.php");
exit();
?>
