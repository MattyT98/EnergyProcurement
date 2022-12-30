<?php
session_start();
require __DIR__."/../security_check_user.php";

$QID = filter_input(INPUT_POST,'quoteID',FILTER_SANITIZE_SPECIAL_CHARS);
$STATUS = filter_input(INPUT_POST,'status',FILTER_SANITIZE_SPECIAL_CHARS);
if (isset($QID) && isset($STATUS))
{
    if (UpdateQuoteStatus($PDO,$QID,$STATUS));
    {
        //Redirect to clients home with success message
        print "Successfully added new quote for client: ".$_SESSION['username'];
    }
}
else{
    print "Error: Quote ID or status not set.";
}
?>