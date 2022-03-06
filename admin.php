<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("location: adminlogin.php");
  exit;
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

  <title>Admin Profile</title>
  <!-- <link rel="stylesheet" href="style.css"> -->
</head>

<body>

  <?php require 'navbar.php' ?>

  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-4 col-md-6 col-lg-4 bg-warning mx-auto">
        <h1 class="text-center">Options</h1>
        <hr>
        <div class="col-md-8 mx-auto">
          <div class="m-2">
            <a type="submit" name="submit" class=" btn btn-dark px-5 mx-5" href="addadmin.php">Add New Admin</a>
          </div>
          <div class="m-2">
            <a type="submit" name="submit" class=" btn btn-dark px-5 mx-5" href="donor-list.php">Donor List</a>
          </div>
          <div class="m-2">
            <a type="submit" name="submit" class=" btn btn-dark px-5 mx-5" href="donor-reg.php">Add Donor</a>
          </div>
          <div class="m-2">
            <a type="submit" name="submit" class=" btn btn-dark px-5 mx-5" href="edit-donor-info.php">Edit Donor</a>
          </div>
          <div class="m-2">
            <a type="submit" name="submit" class=" btn btn-dark px-5 mx-5" href="signup.php">Add New User</a>
          </div>
          <div class="m-2">
            <a type="submit" name="submit" class=" btn btn-dark px-5 mx-5" href="userlist.php">User List</a>
          </div>
          <div class="m-2">
            <a type="submit" name="submit" class=" btn btn-dark px-5 mx-5" href="edit-user.php">Edit User List</a>
          </div>
          <div class="m-2">
            <a type="submit" name="submit" class=" btn btn-dark px-5 mx-5" href="addblood.php">Add Blood Units</a>
          </div>
          <div class="m-2">
            <a type="submit" name="submit" class=" btn btn-dark px-5 mx-5" href="edit-bloodstock.php">Edit Blood Units</a>
          </div>
          <div class="m-2">
            <a type="submit" name="submit" class=" btn btn-dark px-5 mx-5" href="bloodstock.php">Blood Stock</a>
          </div>
          <div class="m-2">
            <a type="submit" name="submit" class=" btn btn-dark px-5 mx-5" href="blood-request-list.php">Blood Requests</a>
          </div>
          <div class="m-2">
            <a type="submit" name="submit" class=" btn btn-dark px-5 mx-5" href="blood.php">Blood Info</a>
          </div>
          <div class="m-2">
            <a type="submit" name="submit" class=" btn btn-dark px-5 mx-5" href="payment.php">Payment</a>
          </div>
          <div class="m-2">
            <a type="submit" name="submit" class=" btn btn-dark px-5 mx-5" href="bill-list.php">Bill List</a>
          </div>
        </div>
      </div>
      <div class="col-sm-8 col-md-6 col-lg-8 bg-success">
        <h1 class="text-center">Admin Profile</h1>
        <h2 class="text-center">logged-in as <?php echo $_SESSION['email'] ?></h2>
        <hr>
      </div>
    </div>
  </div>

  <!-- Optional JavaScript; choose one of the two! -->
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <!-- Option 2: Separate Popper and Bootstrap JS -->

  <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>