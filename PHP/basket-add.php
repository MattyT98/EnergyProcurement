<?PHP
session_start();
require "./basket-control.php";
$PID = $_GET['productID'];
$PID = filter_var($PID,FILTER_VALIDATE_INT);
$QTY = $_GET['quantity'];
$QTY = filter_var($QTY,FILTER_VALIDATE_INT);

AddToBasket($PID,$QTY);

header("Location: ../User/Material-Masters/product.php?id=$PID&alert=added+$PID+$QTY");
?>