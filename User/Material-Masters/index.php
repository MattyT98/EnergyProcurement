<?php
session_start();
require __DIR__ . '/../../PHP/security_check_user.php'; //Does the necessary security check.
include("../../Partials/Material-Masters-Nav.php");

$ITEMS = GetAllProducts($PDO); //Returns empty array on fail or none.

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
                    <h1 class="display-4 py-2 text-truncate">Products</h1>
                    <div class="container mb-3 mt-3" style="background-color: #e9ecef; opacity: 0.9;">
                        <?php
                            foreach ($ITEMS as $item) {
                                $iID = $item['id'];
                                $iName = $item['name'];
                                $iDesc = $item['description'];
                                $iLow = $item['lowprice'];
                                $iHigh = $item['highprice'];

                                echo
                                "  <div class=\"card text-white bg-secondary mb-3\" style=\"max-width: 18rem;\">
                                            <h5 class=\"card-header\">$iName</h5>
                                            <div class=\"card-body\">
                                            <p class=\"card-text\">$iDesc</p>
                                            <a href=\"product.php?id=$iID\" class=\"btn btn-outline-light\" style=\"width: 10rem;\">View Details</a> 
                                            </div>
                                        </div>"; 
                            };
                        ?>
                    </div>
                </div>
            </section>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    </body>
    
    <footer>
    </footer>
</html>