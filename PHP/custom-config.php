<?php
session_start();
unset($_SESSION['theme']);
// $theme = "CSS/main_theme.css";

if(isset($_POST['theme0'])){
    $theme = "CSS/main_theme.css";
}
elseif(isset($_POST['theme1'])){
    $theme = "CSS/dark_theme.css";
}
elseif(isset($_POST['theme2'])){
    $theme = "CSS/green_theme.css";
} else{
    $theme = "CSS/main_theme.css";
}

$_SESSION['theme'] = $theme;
header("Location:../Resources/customisation.php");
?>