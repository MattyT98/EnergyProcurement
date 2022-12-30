<?php
require("database_interface.php");

if (isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    VerifyUserSession($PDO,$username);
}
else
{
    $route = "../User/login.php";
    header("Location: $route");
}
?>