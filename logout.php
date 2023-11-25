<?php
session_start();
session_destroy();
session_start();
$_SESSION["success_message"] = "Logout Success";
header("Location: login.php");
?>
