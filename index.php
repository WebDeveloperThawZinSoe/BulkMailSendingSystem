<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION["normal_user_role"])) {
   header("location:user/index.php");
}else if(isset($_SESSION['username']) && isset($_SESSION["admin_user_role"])){
    header("location:admin/index.php");
}else{
    header("Location: login.php");
    exit();
}
?>