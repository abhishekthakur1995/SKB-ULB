<?php
session_start();

session_regenerate_id();
$_SESSION = array(); 
session_destroy();
session_unset();
 
header("location: index.php");
exit;
?>
