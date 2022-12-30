<?PHP
require './database_interface.php';
$QID=filter_input(INPUT_GET,'qid',FILTER_VALIDATE_INT);
$STATUS = filter_input(INPUT_GET,'status',FILTER_SANITIZE_SPECIAL_CHARS);
if (UpdateQuoteStatus($PDO,$QID,$STATUS))
    header("Location: ../Staff/client-requests/");
else
{
    print "Error updating status";
    die;
}   
?>