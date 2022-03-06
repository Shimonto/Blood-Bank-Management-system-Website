<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: home.php");
    exit;
}
require 'db.php';
// Die if connection was not successful
if (!$conn) {
    die("Sorry we failed to connect: " . mysqli_connect_error());
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Bill List</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php require 'navbar.php' ?>

    <div class="container mt-5 p-5">
        <h1 class="text-center">Bill List</h1>
        <hr>
        <div class="row">
            <div class="col">
                <div class="m-5">
                    <table id = 'table' class="table table-dark table-striped table-hover text-center" id="table">
                        <thead>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Receipt No</th>
                                <th scope="col">Blood Group</th>
                                <th scope="col">Email</th>
                                <th scope="col">Number of Blood bag</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Option</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $sql = "SELECT * FROM `bill`";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {

                                echo " <tr>
                                <td>" . $row['date'] . "</td>
                                <td>" . $row['receipt_no'] . "</td>
                                <td>" . $row['bloodgroup'] . "</td>
                                <td>" . $row['email'] . "</td>
                                <td>" . $row['unit'] . "</td>
                                <td>" . $row['price'] . "</td>
                                <td><button class='print btn btn-sm btn-danger' id=" . $row['receipt_no'] . ">print receipt</button></td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#table').DataTable();
    });
  </script>
    <script>
        print = document.getElementsByClassName('print');
        Array.from(print).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit");
                sno = e.target.id;

                if (confirm("Are you sure you want to print ?")) {
                    console.log("yes");
                    window.location = `printbill.php?id=${sno}`;
                    // TODO: Create a form and use post request to submit a form
                } else {
                    console.log("no");
                }
            })
        })
    </script>

</body>

</html>