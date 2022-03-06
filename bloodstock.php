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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>Home</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <?php require 'navbar.php' ?>

  <div class="container mt-5 p-5">
    <h1 class="text-center">Blood Stock</h1>
    <hr>
    <div class="row">
      <div class="col">
        <div class="m-5">
          <table class="table table-light text-center" id="table">
            <h5 class="text-center">Number of Blood Bag into the Stock</h5>
            <thead>
              <tr>
                <th scope="col">Blood Group</th>
                <th scope="col">Unit</th>
              </tr>
            </thead>

            <tbody>
              <?php
              $Aplus = 0;
              $Aminus = 0;
              $Bplus = 0;
              $Bminus = 0;
              $ABplus = 0;
              $ABminus = 0;
              $Oplus = 0;
              $Ominus = 0;

              $sql = "SELECT bloodgroup FROM `bloodstock`";
              $result = mysqli_query($conn, $sql);
              while ($row = mysqli_fetch_assoc($result)) {

                if ($row['bloodgroup'] == 'B+') {
                  $Bplus = $Bplus + 1;
                } elseif ($row['bloodgroup'] == 'B-') {
                  $Bminus = $Bminus + 1;
                } elseif ($row['bloodgroup'] == 'A+') {
                  $Aplus = $Aplus + 1;
                } elseif ($row['bloodgroup'] == 'A-') {
                  $Aminus = $Aminus + 1;
                } elseif ($row['bloodgroup'] == 'AB+') {
                  $ABplus = $ABplus + 1;
                } elseif ($row['bloodgroup'] == 'AB-') {
                  $ABminus = $ABminus + 1;
                } elseif ($row['bloodgroup'] == 'O+') {
                  $Oplus = $Oplus + 1;
                } elseif ($row['bloodgroup'] == 'O-') {
                  $Ominus = $Ominus + 1;
                }
              }

              echo "
              <tr>
                <td>A+</td>
                <td>" . $Aplus . "</td>
              </tr>
              <tr>
                <td>A-</td>
                <td>" . $Aminus . "</td>
              </tr>
              <tr>
                <td>B+</td>
                <td>" . $Bplus . "</td>
              </tr>
              <tr>
                <td>B-</td>
                <td>" . $Bminus . "</td>
              </tr>
              <tr>
                <td>AB+</td>
                <td>" . $ABplus . "</td>
              </tr>
              <tr>
                <td>AB-</td>
                <td>" . $ABminus . "</td>
              </tr>
              <tr>
                <td>O+</td>
                <td>" . $Oplus . "</td>
              </tr>
              <tr>
                <td>O-</td>
                <td>" . $Ominus . "</td>
              </tr>";
              ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="col">
        <h5 class="text-center">Number of Donor :
          <?php
          $sql = "SELECT COUNT(*) as cnt FROM `donor-reg`";
          $result = mysqli_query($conn, $sql);
          $row = mysqli_fetch_assoc($result)['cnt'];
          echo "$row";
          ?>
        </h5>

        <div class="m-4">
          <table class="table table-light text-center" id="table">
            <h5 class="text-center">Number of Donor for each Bloodgroup</h5>
            <thead>
              <tr>
                <th scope="col">Blood Group</th>
                <th scope="col">Number of Donor </th>
              </tr>
            </thead>

            <tbody>
              <?php
              $Aplus = 0;
              $Aminus = 0;
              $Bplus = 0;
              $Bminus = 0;
              $ABplus = 0;
              $ABminus = 0;
              $Oplus = 0;
              $Ominus = 0;

              $sql = "SELECT bloodgroup FROM `donor-reg`";
              $result = mysqli_query($conn, $sql);
              while ($row = mysqli_fetch_assoc($result)) {

                if ($row['bloodgroup'] == 'B+') {
                  $Bplus = $Bplus + 1;
                } elseif ($row['bloodgroup'] == 'B-') {
                  $Bminus = $Bminus + 1;
                } elseif ($row['bloodgroup'] == 'A+') {
                  $Aplus = $Aplus + 1;
                } elseif ($row['bloodgroup'] == 'A-') {
                  $Aminus = $Aminus + 1;
                } elseif ($row['bloodgroup'] == 'AB+') {
                  $ABplus = $ABplus + 1;
                } elseif ($row['bloodgroup'] == 'AB-') {
                  $ABminus = $ABminus + 1;
                } elseif ($row['bloodgroup'] == 'O+') {
                  $Oplus = $Oplus + 1;
                } elseif ($row['bloodgroup'] == 'O-') {
                  $Ominus = $Ominus + 1;
                }
              }

              echo "
              <tr>
                <td>A+</td>
                <td>" . $Aplus . "</td>
              </tr>
              <tr>
                <td>A-</td>
                <td>" . $Aminus . "</td>
              </tr>
              <tr>
                <td>B+</td>
                <td>" . $Bplus . "</td>
              </tr>
              <tr>
                <td>B-</td>
                <td>" . $Bminus . "</td>
              </tr>
              <tr>
                <td>AB+</td>
                <td>" . $ABplus . "</td>
              </tr>
              <tr>
                <td>AB-</td>
                <td>" . $ABminus . "</td>
              </tr>
              <tr>
                <td>O+</td>
                <td>" . $Oplus . "</td>
              </tr>
              <tr>
                <td>O-</td>
                <td>" . $Ominus . "</td>
              </tr>";
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Optional JavaScript; choose one of the two! -->
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <!-- Option 2: Separate Popper and Bootstrap JS -->

</body>

</html>