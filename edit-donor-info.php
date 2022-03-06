<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("location: adminlogin.php");
  exit;
}
$insert = false;
$update = false;
$updatefail = false;
$delete = false;
require 'db.php';

// Die if connection was not successful
if (!$conn) {
  die("Sorry we failed to connect: " . mysqli_connect_error());
}

if (isset($_GET['delete'])) {
  $sno = $_GET['delete'];
  $sql = "DELETE FROM `donor-reg` WHERE `email` = '$sno'";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    $delete = true;
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['snoEdit'])) {
    // Update the record
    $sno = $_POST["snoEdit"];
    $name = $_POST['nameEdit'];
    $email = $_POST['emailEdit'];
    $birthday = $_POST['birthdayEdit'];
    $bloodgroup = $_POST['bloodgroupEdit'];
    $gender = $_POST['genderEdit'];
    $mobilenumber = $_POST['mobilenumberEdit'];
    $city = $_POST['cityEdit'];
    // Sql query to be executed
    $sql = "UPDATE `donor-reg` SET `name` = '$name' , `email` = '$email', `birthday` = '$birthday', `bloodgroup` = '$bloodgroup', `gender` = '$gender', `mobilenumber` = '$mobilenumber', `city` = '$city'  WHERE `donor-reg`.`email` = '$sno'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $update = true;
    } else {
      $updatefail = true;
      // echo "<script>alert('Could not update the record successfully !!')</script>";
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
  <!-- <link rel="stylesheet" href="style.css"> -->
  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <title>Edit Donor Information</title>
</head>

<body>

  <!-- Edit Modal -->
  <div class="modal fade mx-auto" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog bg-dark text-white" role="document">
      <div class="modal-content bg-dark text-white">
        <div class="modal-header">
          <h5 class="modal-title text-center" id="editModalLabel">Edit Donor Information</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="edit-donor-info.php" method="post" class="item-center mx-5">
          <input type="hidden" name="snoEdit" id="snoEdit">
          <div class="mb-3 col-md-6">
            <label for="exampleInputName1" class="form-label"> Name</label>
            <input type="text" class="form-control" name="nameEdit" id="nameEdit">
          </div>
          <hr>
          <div class="mb-3 col-md-6">
            <label for="exampleInputEmail1" class="form-label">Email Address</label>
            <input type="email" class="form-control" name="emailEdit" id="emailEdit" aria-describedby="emailHelp">
          </div>
          <hr>
          <div class="mb-3 col-md-6">
            <label for="exampleInputDate1" class="form-label">Birth Day</label>
            <input type="date" class="form-control" name="birthdayEdit" id="birthdayEdit">
          </div>
          <hr>
          <div class="mb-3 col-md-6">
            <label for="exampleInputDate1" class="form-label">Blood Group</label>
            <select name="bloodgroupEdit" class="form-select" id="bloodgroupEdit" aria-label="Default select example">
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
            <select name="genderEdit" class="form-select" id="genderEdit" aria-label="Default select example">
              <option value="Male" selected>Male</option>
              <option value="Female">Female</option>
            </select>
          </div>
          <hr>
          <div class="mb-3 col-md-6">
            <label for="exampleInputNumber1" class="form-label">Mobile Number</label>
            <input type="number" class="form-control" name="mobilenumberEdit" id="mobilenumberEdit">
          </div>
          <hr>
          <div class="mb-3 col-md-6">
            <label for="exampleInputName1" class="form-label">City</label>
            <input type="text" class="form-control" name="cityEdit" id="cityEdit">
          </div>
          <div class="modal-footer">
            <!-- <button type="submit" class="btn btn-outline-danger px-5 py-3">Submit</button> -->
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php require 'navbar.php' ?>

  <?php
  if ($delete) {
    echo "<div class='text-center alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Deleted successfully !! 
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
  <?php
  if ($update) {
    echo "<div class='text-center alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Information Updated Successfully !!
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
  <?php
  if ($updatefail) {
    echo "<div class=' text-center alert alert-danger alert-dismissible fade show' role='alert'>
    <strong>Failed!</strong> Could not update the Information successfully !!
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>

  <div class="container mt-3">
    <h1 class="text-center">Edit Donor Information</h1>
    <hr>
    <div class="m-5">
      <table class="table table-dark table-striped table-hover text-center" id="table">
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Email Address</th>
            <th scope="col">Birth Day</th>
            <th scope="col">Blood Group</th>
            <th scope="col">Gender</th>
            <th scope="col">Mobile Number</th>
            <th scope="col">City</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $sql = "SELECT * FROM `donor-reg` ORDER BY `name`";
          $result = mysqli_query($conn, $sql);
          while ($row = mysqli_fetch_assoc($result)) {
            echo " <tr>
                          <td>" . $row['name'] . "</td>
                          <td>" . $row['email'] . "</td>
                          <td>" . $row['birthday'] . "</td>
                          <td>" . $row['bloodgroup'] . "</td>
                          <td>" . $row['gender'] . "</td>
                          <td>" . $row['mobilenumber'] . "</td>
                          <td>" . $row['city'] . "</td>
                          <td> <button class='edit btn btn-sm btn-danger' id=" . $row['email'] . ">Edit</button> <button class='delete btn btn-sm btn-danger' id=d" . $row['email'] . ">Delete</button>  </td>
                          </tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
    <hr>
  </div>

  <!-- Optional JavaScript; choose one of the two! -->
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <!-- Option 2: Separate Popper and Bootstrap JS -->

  <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#table').DataTable();
    });
  </script>

  </script>

  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit");
        tr = e.target.parentNode.parentNode;
        name = tr.getElementsByTagName("td")[0].innerText;
        email = tr.getElementsByTagName("td")[1].innerText;
        birthday = tr.getElementsByTagName("td")[2].innerText;
        bloodgroup = tr.getElementsByTagName("td")[3].innerText;
        gender = tr.getElementsByTagName("td")[4].innerText;
        mobilenumber = tr.getElementsByTagName("td")[5].innerText;
        city = tr.getElementsByTagName("td")[6].innerText;

        console.log(name, email, birthday, bloodgroup, gender, mobilenumber, city);

        nameEdit.value = name;
        emailEdit.value = email;
        birthdayEdit.value = birthday;
        bloodgroupEdit.value = bloodgroup;
        genderEdit.value = gender;
        mobilenumberEdit.value = mobilenumber;
        cityEdit.value = city;

        snoEdit.value = e.target.id;
        console.log(e.target.id)
        $('#editModal').modal('toggle');
      })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit");
        sno = e.target.id.substr(1);

        if (confirm("Are you sure you want to delete!")) {
          console.log("yes");
          window.location = `edit-donor-info.php?delete=${sno}`;
          // TODO: Create a form and use post request to submit a form
        } else {
          console.log("no");
        }
      })
    })
  </script>

</body>

</html>