<?php
session_start(); // start the session to access session variables
session_unset(); // unset all session variables
session_destroy(); // destroy the session

header("Location: login.php");

?>
