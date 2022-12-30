<?PHP
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
        <link href='CSS/bootstrap.min.css' rel='stylesheet'>
        <link href='CSS/main_theme.css' rel='stylesheet'>
        <?php  
            if ($theme != "CSS/main_theme.css"){
                echo '<link href="'.$theme.'" rel="stylesheet" type="text/css" />';
            }       
        ?>
    </head>

    <body>
        <section id="cover" class="min-vh-100">
            <div id="cover-caption">
                <div class="container">
                    <div class="row text-white">
                        <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10 mx-auto text-center form p-4">
                            <h1 class="display-4 py-2 text-truncate">User Select</h1>
                            <div class="px-2 justify-content-center">
                                <div id="landingchoice" class="justify-content-center"></div>
                                <a href="User/login.php"><input type="button" class="btn btn-primary" value="Client"></a>
                                <a href="Staff/login.php"><input type="button" class="btn btn-primary" value="Staff"></a>
				<a href="Resources/customisation.php"><input type="button" class="btn btn-primary" value="Themes"></a>
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

