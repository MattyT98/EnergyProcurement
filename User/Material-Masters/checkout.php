<?php
session_start();
require __DIR__ . '/../../PHP/security_check_user.php'; //Does the necessary security check.
require __DIR__.'/../../PHP/basket-control.php';
include("../../Partials/Material-Masters-Nav.php");

$b = GetBasket();
$idArray=[];
$ITEM=null;
$QTY=[];
foreach ($b as $item){
    array_push($idArray,$item['productID']);
    array_push($QTY,$item['quantity']);
}

$itemsByIDs = GetProductsByIDs($PDO, $idArray);

if(isset($_SESSION['theme'])){
    $theme = $_SESSION['theme'];
}else {
    $theme = "CSS/main_theme.css";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href='../../CSS/bootstrap.min.css' rel='stylesheet'>
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
                    <h1 class="display-4 py-2 text-truncate">Checkout</h1>
                    <div class="container mb-3 mt-3" style="background-color: #e9ecef; opacity: 0.9;">
                    <table class="table table-striped table-bordered" style="width: 100%" id="quoteDetailsTable">
                    <thead>
                        <tr>
                            <th>Product ID</th>
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
                        
                        foreach ($itemsByIDs as $ITEM) {
                            $iID = $ITEM['id'];
                            $iName = $ITEM['name'];
                            $iDesc = $ITEM['description'];
                            $iLow = $ITEM['lowprice'];
                            $iHigh = $ITEM['highprice'];
                            $iQty = $b[array_search($ITEM['id'],array_column($b,'productID'))]['quantity'];

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
                        <td><?PHP echo $lowTotal;?></td>
                        <td><?PHP echo $highTotal;?></td>
                    </tr>
                </table>

                    </div>
                </div>
                <a href="../../PHP/basket-submit.php"><input type="button" class="btn btn-success" style="margin: 25px 50px 50px 1246px" value="Submit"></a>
            </section>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <!--Dont make this a DataTable() it needs to stay in this order-->
</body>

</html>