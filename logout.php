<?php 
session_start();
$_session = array();
session_destroy();
header("location: strona_startowa.php?select=all");
exit;
?>