<?php
session_start();
require './security_check_staff.php';

$name = filter_input(INPUT_POST,'name',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$pass = filter_input(INPUT_POST,'password',FILTER_SANITIZE_SPECIAL_CHARS);
$hashPass = password_hash($pass,PASSWORD_DEFAULT);
if ($hashPass){
    $r = CreateClientAccount($PDO,$name,$pass);
    if ($r)
        header("Location: ../Staff/");
    else
    {
        print "Error creating account.";
        die;
    }
}
