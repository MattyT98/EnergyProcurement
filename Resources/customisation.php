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
<meta charset="utf-8">

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<?php echo '<link href="../'.$theme.'" rel="stylesheet" type="text/css" />'; ?>
</head>


<body>
<div class="container mb-3 mt-1">
        <a href="../index.php">
            <button type="button" class="btn btn-primary">Back</button>
        </a>
    </div>
    <div class="container mb-3 mt-3">
        <table class="table table-striped table-bordered" style="width: 100%" id="quoteDetailsTable">
            <tr>
            <form  method="post" action="../PHP/custom-config.php">
                <th><button type="submit"  style="width: 100%" class="btn btn-primary" name="theme0" value="0"> Main Theme </button></th>
                <th><button type="submit"  style="width: 100%" class="btn btn-primary" name="theme1" value="1"> Dark Theme </button></th>
                <th><button type="submit"  style="width: 100%" class="btn btn-primary" name="theme2" value="2"> Green Theme </button></th>
            </form>
        </tr>
        </table>
    </div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</body>

</html>
