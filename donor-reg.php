<?php

session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("location: userlogin.php");
  exit;
}

$Exists = false;
require 'db.php';
// Die if connection was not successful
if (!$conn) {
  die("Sorry we failed to connect: " . mysqli_connect_error());
} else {
  if (isset($_SESSION['user'])) {
    // Check whether this username exists
    $find = $_SESSION['email'];
    $existSql = "SELECT * FROM `donor-reg` WHERE email = '$find'";
    $result = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows($result);

    if ($numExistRows > 0) {
      $Exists = "User Already Exists";
    }
  }
}
?>

<?php
$showAlert = false;
$failed = false;
$showError = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $name = $_POST['name'];
  $email = $_POST['email'];
  $birthday = $_POST['birthday'];
  $bloodgroup = $_POST['bloodgroup'];
  $mobilenumber = $_POST['mobilenumber'];
  $city = $_POST['city'];
  $gender = $_POST['gender'];

  require 'db.php';
  
  if (!$conn) {
    die("Sorry we failed to connect: " . mysqli_connect_error());
  } else {

    // Check whether this username exists
    $existSql = "SELECT * FROM `donor-reg` WHERE email = '$email'";
    $result = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows($result);

    if ($numExistRows > 0) {
      $showError = "User Already Exists";
    } else {

      $sql = "INSERT INTO `donor-reg` (`name`, `email`, `birthday`, `bloodgroup`, `gender`, `mobilenumber`, `city`) VALUES ('$name', '$email', '$birthday', '$bloodgroup', '$gender', '$mobilenumber', '$city')";
      $result = mysqli_query($conn, $sql);

      if ($result) {
        $showAlert = true;
      } else {
        $failed = true;
      }
    }
  }
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

  <title>Donor Regestration</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <?php require 'navbar.php' ?>

  <?php
  if ($showAlert) {
    echo ' <div class="text-center alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!!</strong> Donor Regestration is successfully done.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> ';
  }
  if ($failed) {
    echo ' <div class="text-center alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!!</strong> Donor Regestration failed.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> ';
  }
  if ($showError) {
    echo ' <div class="text-center alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!!</strong> ' . $showError . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> ';
  }
  ?>

  <?php
  if (!$Exists || isset($_SESSION['admin'])) {
    echo '
  <div class="container mt-5 p-5 ">
    <h1 class="text-center">Donor Regestration Form</h1>
    <form class="center" action="donor-reg.php" method="post">
      <div class="mb-3 col-md-6">
        <label for="exampleInputName1" class="form-label">Name</label>
        <input type="text" class="form-control" name="name" id="name">
      </div>
      <hr>
      <div class="mb-3 col-md-6">
        <label for="exampleInputEmail1" class="form-label">Email Address</label>
        <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
      </div>
      <hr>
      <div class="mb-3 col-md-6">
        <label for="exampleInputDate1" class="form-label">Birth Day</label>
        <input type="date" class="form-control" name="birthday" id="birthday">
      </div>
      <hr>
      <div class="mb-3 col-md-6">
        <label for="exampleInputDate1" class="form-label">Blood Group</label>
        <select name="bloodgroup" id="bloodgroup" class="form-select" aria-label="Default select example">
          <option value="A+" selected>A+</option>
          <option value="A-">A-</option>
          <option value="B+">B+</option>
          <option value="B-">B-</option>
          <option value="O+">O+</option>
          <option value="O-">O-</option>
          <option value="AB+">AB+</option>
          <option value="AB-">AB-</option>
        </select>
      </div>
      <hr>
      <div class="mb-3 col-md-6">
        <label for="exampleInputDate1" class="form-label">Gender</label>
        <select name="gender" class="form-select" id="gender" aria-label="Default select example">
          <option value="Male" selected>Male</option>
          <option value="Female">Female</option>
        </select>
      </div>
      <hr>
      <div class="mb-3 col-md-6">
        <label for="exampleInputNumber1" class="form-label">Mobile Number</label>
        <input type="number" class="form-control" name="mobilenumber" id="mobilenumber">
      </div>
      <hr>
      <div class="mb-3 col-md-6">
        <label for="exampleInputName1" class="form-label">City</label>
        <input type="text" class="form-control" name="city" id="city">
      </div>
      <hr>
      <div class="mb-3">
        <button type="submit" class="btn btn-outline-danger px-5 py-3">Submit</button>
      </div>
      <hr>
    </form>
  </div>';
  } else {
    echo '<div class="text-center alert alert-danger" role="alert">
    You have already registered ! <a href="edit-user-info.php" class="alert-link">Click hear to see your details.</a>
  </div>';
  }
  ?>


  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->

  <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>