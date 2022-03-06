<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: home.php");
    exit;
}
require 'db.php';
// Die if connection was not successful

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Print Bill</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php require 'navbar.php' ?>

    <div class="container mt-5 p-5">
        <h1 class="text-center">Blood Bank</h1>
        <hr>
        <div class="row">
            <div class="col">
                <div class="m-5">
                    <table class="table table-light text-center" id="table">
                        <h5 class="text-center">Receipt</h5>

                        <tbody>
                            <?php
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $database = "bbms";

                            // Create a connection
                            $conn = mysqli_connect($servername, $username, $password, $database);
                            $id = $_GET['id'];
                            
                            $sql = "SELECT * FROM `bill` where `receipt_no` = '$id'";
                            $result = mysqli_query($conn, $sql);
                            if ($result->num_rows > 0) {
                            $row = mysqli_fetch_assoc($result);

                                    echo "
                            <tr>
                                <td>Date</td>
                                <td>" . $row['date'] . "</td>
                            </tr>
                            <tr>
                                <td>Recipt Number</td>
                                <td>" . $row['receipt_no']  . "</td>
                            </tr>
                            <tr>
                                <td>blood group</td>
                                <td>" . $row['bloodgroup'] . "</td>
                            </tr>
                            <tr>
                                <td>Mail</td>
                                <td>" . $row['email'] . "</td>
                            </tr>
                            <tr>
                                <td>Number of blood bag</td>
                                <td>" . $row['unit'] . "</td>
                            </tr>
                            <tr>
                                <td>Total Price</td>
                                <td>" . $row['price'] . "</td>
                            </tr>
                            ";
                            }
                            
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
    window.print();
    </script>
    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->

</body>

</html>