<?php
session_start();
require './basket-control.php';
require './database_interface.php';
$QID = filter_input(INPUT_GET,'qid',FILTER_VALIDATE_INT,FILTER_NULL_ON_FAILURE);

$b = GetBasket();
if (count($b) > 0)
{
    if (!isset($QID))
        CreateNewQuote($PDO);
    else
        UpdateQuoteItems($PDO,$QID);
}
ResetBasket();

header("Location: ../User/My-Requests/");
?>