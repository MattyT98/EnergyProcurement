<?php
session_start();
require "../../PHP/security_check_user.php"; //Does the necessary security check.
include("../../Partials/My-Requests-Nav.php");

$QUOTE = []; GetQuoteFromID($PDO, $_SESSION['username']);//Returns empty array on fail or none.
$ITEMS = [];
if (isset($_GET['id'])){
    $getID = $_GET['id'];
    $QID = filter_var($getID,FILTER_VALIDATE_INT);
    $QUOTE = GetQuoteFromID($PDO,$QID);//Returns empty array on fail or none.
    $ITEMS = GetProductsForQuote($PDO,$QID);
}else{
    //Error, redirect or produce error.
}

if(isset($_SESSION['theme'])){
    $theme = $_SESSION['theme'];
}else {
    $theme = "CSS/main_theme.css";
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link href='../../CSS/main_theme.css' rel='stylesheet'> 
        <?php  
            if ($theme != "CSS/main_theme.css"){
                echo '<link href="../../'.$theme.'" rel="stylesheet" type="text/css" />';
            }       
        ?>
    </head>

    <body>
        <div class="container-flex">
                <section id="cover" class="min-vh-100" style="display:revert">
                    <div class="container-flex" id="cover-caption">
                        <h1 class="display-4 py-2 text-truncate">Details</h1>
                        <div class="container mb-3 mt-3" style="background-color: #e9ecef; opacity: 0.9;">
                            <table class="table table-striped table-bordered" style="width: 100%" id="quoteDetailsTable">
                                <thead>
                                    <tr>
                                        <th>SKU</th>
                                        <th>Quantity</th>
                                        <th>Product/Service</th>
                                        <th>Description</th>
                                        <th>Lowest</th>
                                        <th>Highest</th>
                                    </tr>
                                </thead>
                                <?PHP
                                $lowTotal = 0.00;
                                $highTotal = 0.00;
                                foreach ($ITEMS as $item) {
                                    $iID = $item['id'];
                                    $iName = $item['name'];
                                    $iDesc = $item['description'];
                                    $iLow = $item['lowprice'];
                                    $iHigh = $item['highprice'];
                                    $iQty = $item['quantity'];

                                    echo "
                                    <tr>
                                        <td>$iID</td>
                                        <td>$iQty</td>
                                        <td>$iName</td>
                                        <td>$iDesc</td>
                                        <td>$iLow</td>
                                        <td>$iHigh</td>
                                    </tr>";
                                    $lowTotal += doubleval($iLow) * intval($iQty);
                                    $highTotal += doubleval($iHigh) * intval($iQty);
                                }
                                ?>
                                <tr>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>Estimates:</td>
                                    <td><?php echo $lowTotal;?></td>
                                    <td><?php echo $highTotal;?></td>
                                </tr>
                            </table>
                            <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
                            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
                            <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
                            <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
                            <!--Dont make this a DataTable() it needs to stay in this order-->
                        </div>
                    </div>
                </section>
        </div>
    </body>

    <footer>
    </footer>
</html>