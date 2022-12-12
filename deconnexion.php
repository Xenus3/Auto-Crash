<?php

session_start();

$_SESSION = array();

session_destroy();

if (isset($_COOKIE['souvient_toi'])) {
    unset($_COOKIE['souvient_toi']); 
    setcookie("souvient_toi", NULL , -1, "/");
    
} 


header("location:index.php");
exit;

?>

