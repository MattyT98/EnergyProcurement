<?php
require("database_interface.php");

if (isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    VerifyStaffSession($PDO,$username);
}
else
{
    $route = "../Staff/login.php";
    header("Location: $route");
}
?>