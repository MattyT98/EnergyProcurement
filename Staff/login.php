<?php
session_start();
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
                            <h1 class="display-4 py-2 text-truncate">Staff Login</h1>
                            <div class="px-2 justify-content-center">
                            <div class="background"></div>
                                <form method="post" class="justify-content-center" action="../PHP/login_staff.php">
                                    <div class="container mb-3 mt-3" style="display:block">
                                        <input class="form-control" type="text" name="username" placeholder="username or email" />
                                    </div>
                                    <div class="container mb-3 mt-3" style="display:block">
                                        <input class="form-control" type="password" name="password" placeholder="******"/>
                                    </div>
                                    <input type="submit" value="Submit" class="btn btn-success" data-mdb-ripple-color="dark"/>
                                    <a href="../index.php"><input type="button" class="btn btn-primary" value="Home"></a>
                                </form>
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