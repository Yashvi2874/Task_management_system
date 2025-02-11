<?php

session_start(); 

session_unset();  

session_destroy();  

if (isset($_COOKIE[session_name()]))   
{  
    setcookie("username", "" , time() - 3600, '/');    
}  

header("Location: login.php");  

exit(); 

?>