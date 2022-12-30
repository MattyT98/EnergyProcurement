<?php
session_start();
require __DIR__.'/../PHP/security_check_user.php'; //Does the necessary security check.

if (isset($_GET['name'])){
$productName = $_GET['name'];
$ITEMS=SearchProducts($PDO,$productName);
}else{
    $ITEMS=null;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href='../../CSS/bootstrap.min.css' rel='stylesheet'>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link href='../../CSS/styles.css' rel='stylesheet'>

    </head>

    <body>
        <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" >Group 7</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Material-Masters/index.php">Browse Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="My-Requests/index.php">My Requests</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Material-Masters/checkout.php">View Cart</a>
            </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" method="GET">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" id="name" name="name">
                 <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            <a class="btn btn-outline-danger my-2 my-sm-0" style="margin-left: 10px; " type="button" href="../PHP/logout_user.php">Logout</a>
        </div>
        </nav>
  </head>
        </header>
        <div class="container-flex">
            <section id="cover" class="min-vh-100" style="display:revert">
                <div class="container-flex" id="cover-caption">
                    <h1 class="display-4 py-2 text-truncate">Products</h1>
                    <div class="container mb-3 mt-3" style="background-color: #e9ecef; opacity: 0.9;">
                        <?php
                       if($ITEMS==NULL){
                        echo "<p class=\"alert-danger\">Search Term Required.</p>";	
                       }else{
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
                                                <a href=\"Material-Masters/product.php?id=$iID\" class=\"btn btn-outline-light\" style=\"width: 10rem;\">View Details</a> 
                                                </div>
                                            </div>"; 
                           } };
                        ?>
                    </div>
                </div>
            </section>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </body>

</html>