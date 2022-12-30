<?php
session_start();
require('../PHP/security_check_staff.php'); //Does the necessary security check.
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
        <link href='../CSS/bootstrap.min.css' rel='stylesheet'>
        <link href='../CSS/main_theme.css' rel='stylesheet'>
        <?php  
            if ($theme != "CSS/main_theme.css"){
                echo '<link href="../'.$theme.'" rel="stylesheet" type="text/css" />';
            }       
        ?>
    </head>

    <body>
        <section id="cover" class="min-vh-100">
            <div id="cover-caption">
                <div class="container">
                    <div class="row text-white">
                        <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10 mx-auto text-center form p-4">
                            <h1 class="font-weight-light">Logged in : <?php echo $_SESSION['username'];?></h1>
                            <div class="px-2 justify-content-center">
                                <div id="landingchoice" class="justify-content-center"></div>
                                <a href="./client-requests/index.php"><input type="button" class="btn btn-info" value="Client Requests"></a>
                                <a href="./client-accounts/new-client.php"><input type="button" class="btn btn-warning" value="Add New Client"></a>
                                <a href="../PHP/logout_staff.php"><input type="button" class="btn btn-danger" value="Logout"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>

    <footer>
    </footer>
</html>