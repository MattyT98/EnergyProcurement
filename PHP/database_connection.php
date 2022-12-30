<?php
$host = "localhost";
$db = "cssd";
$user = "root";
$pass = "";

$dsn = "mysql:host=$host;dbname=$db;";
$PDO = null;
try
{
    $PDO = new PDO($dsn,$user,$pass);
    return $PDO;
}
catch(Exception $e){
    die($e);
}

?>