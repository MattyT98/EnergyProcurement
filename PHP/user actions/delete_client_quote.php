<?php
session_start();
require __DIR__."/../security_check_user.php";

$QID = filter_input(INPUT_POST,'quoteID',FILTER_SANITIZE_SPECIAL_CHARS);
if (isset($QID))
{
    if (DeleteQuote($PDO,$QID));
    {
        //Redirect to clients home with success message
        print "Successfully deleted quote ".$QID." for client: ".$_SESSION['username'];
    }
}
else{
    print "Error: Quote ID or status not set.";
}
?>