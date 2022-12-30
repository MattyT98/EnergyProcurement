<?php
session_start();
require __DIR__."/../security_check_user.php";

$ITEMS = filter_input(INPUT_POST,'items',FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($ITEMS))
{
    if(is_array($ITEMS))
    {
        if (CreateNewQuote($PDO,$ITEMS));
        {
            //Redirect to clients home with success message
            print "Successfully added new quote for client: ".$_SESSION['username'];
        }
    }
    else{
        print "Error: Posted `items` is not an array.";
    }
}
else{
    print "Error: Posted `items` is not set.";
}

?>