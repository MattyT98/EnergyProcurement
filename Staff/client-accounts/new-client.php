<?PHP
session_start();
require('../../PHP/security_check_staff.php'); //Does the necessary security check.
if(isset($_SESSION['theme'])){
    $theme = $_SESSION['theme'];
}else {
    $theme = "CSS/dark_theme.css";
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
    <a href="../index.php"><input type="button" class="btn btn-secondary" value="Home" style="margin: 10px "></a>           
    <section id="cover" class="min-vh-100" style="display:revert">
        <div class="container-flex" id="cover-caption">
            <h1 class="display-4 py-2 text-truncate">Add New Client</h1>
            <div class="container mb-3 mt-3" style="background-color: #e9ecef; opacity: 0.9;">
                <div class="jumbotron">
                    <form action="../../PHP/new-client.php" method="post" class="justify-content-center">    
                            <div class="container mb-3 mt-3" style="display:block">
                                <label for="username">Username</label>
                                <input name="name" type="name" class="form-control" id="username" aria-describedby="nameHelp" placeholder="Enter Name" minlength="3" required>
                            </div>
                            <div class="container mb-3 mt-3" style="display:block">
                                <label for="passIn">Password</label>
                                <input name="password" type="password" class="form-control" id="passIn" minlength="6" placeholder="******" required>
                            </div>
                                <input type="submit" value="Submit" class="btn btn-success" data-mdb-ripple-color="dark"/>
                    </form>
                </div>                             
            </div>
        </div>
    </section>
              
</div>
</body>
    <footer>
    </footer>
</html>