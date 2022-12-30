<?php
session_start();
require __DIR__ . '/../../PHP/security_check_user.php'; //Does the necessary security check.
include("../../Partials/My-Requests-Nav.php");

$QUOTES = GetClientQuotesFromClientName($PDO, $_SESSION['username']); //Returns empty array on fail or none.
//print $_SESSION['username'];

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
                    <h1 class="display-4 py-2 text-truncate">My Requests</h1>
                    <div class="container mb-3 mt-3" style="background-color: #e9ecef; opacity: 0.9;">
                        <table class="table table-striped table-bordered" style="width: 100%" id="requestsTable">
                            <thead>
                                <tr>
                                    <th>Quote ID</th>
                                    <th>Staff-Member Allocated</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <?php
                            foreach ($QUOTES as $quote) {
                                $qID = $quote['id'];
                                $qStaff = $quote['staffName'];
                                $qStatus = $quote['status'];

                                $actionButtons = "";
                                if ($qStatus == "opened") {
                                    $actionButtons =
                                        '<a href="quote-details.php?id=' . $qID . '"><button type="button" class="btn btn-outline-dark btn-sm">Details</button></a>';               
                                }

                                echo
                                "<tr>
                                    <td>$qID</td>
                                    <td>$qStaff</td>
                                    <td>$qStatus</td>
                                    <td>$actionButtons</td>
                                    </tr>";
                            };
                            ?>
                        </table>

                    </div>
                </div>
        <div class="container mb-3 mt-1">
            <a href="../Material-Masters/">
                <button type="button" class="btn btn-success">New Order</button>
            </a>
        </div>
            </section>
        </div>


        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <script>
            $('#requestsTable').DataTable();
        </script>
    </body>

    <footer>
    </footer>
</html>