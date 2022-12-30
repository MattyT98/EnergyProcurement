<?php
session_start();
require __DIR__ . '/../../PHP/security_check_user.php'; //Does the necessary security check.
require __DIR__.'/../../PHP/basket-control.php';
include("../../Partials/Material-Masters-Nav.php");
$PID = $_GET['id'];
$PID = filter_var($PID,FILTER_VALIDATE_INT);
$ALERT = isset($_GET['alert'])?$_GET['alert']:null;


$ITEM=null;
if ($PID !==false)
    $ITEM = GetProductByID($PDO,$PID); //Returns empty array on fail or none.
    
else{
    //redirect back
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
                    <h1 class="display-4 py-2 text-truncate">
                        <?php
                            $iName = $ITEM['name'];
                            echo $iName;
                        ?>
                    </h1>
                    <div class="container mb-3 mt-3" style="background-color: #e9ecef; opacity: 0.9;">
                        <?php
                            if ($ALERT){
                                $b = GetBasket();
                                
                            /*echo "
                                <div class=\"alert alert-primary\" role=\"alert\">
                                    $ALERT</br>";
                                    print_r($b);

                                echo "</div>";
                            */
                        }
                        ?>
                        <div id="productDetails">
                            <?php
                                $iID = $PID;
                                $iName = $ITEM['name'];
                                $iDesc = $ITEM['description'];
                                $iLow = $ITEM['lowprice'];
                                $iHigh = $ITEM['highprice'];


                                echo
                                "
                                <div class=\"jumbotron\">
                                    <p class=\"lead\"><span>Low: $iLow</span>\t<span>High: $iHigh</span></p>
                                    <hr class=\"my-4\">
                                    <p>$iDesc</p>
                                        <form action=\"../../PHP/basket-add.php\">
                                            <input type=\"hidden\" name=\"productID\" value=\"$iID\">
                                            <h6> <label>Qty:</label> 
                                            <input type=\"number\" name=\"quantity\" max=\"500\" min=\"5\" step=\"5\" value=\"5\" />
                                            <button class=\"btn btn-success btn-sm\" value=\"submit\" href=\"checkout.php\">Add to Q-Order </button></h6>
                                        </form>
                                </div>
                                <a href=\"checkout.php\"><input type=\"button\" class=\"btn btn-danger\" style=\"margin: 25px 50px 50px 1000px\" value=\"View Cart\"a>
                                ";
                            ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </body>

    <footer>
    </footer>
</html>