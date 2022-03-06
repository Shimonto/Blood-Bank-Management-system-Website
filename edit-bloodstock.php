<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: userlogin.php");
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
    $delete = true;
    $sql = "DELETE FROM `bloodstock` WHERE `bagid` = '$sno'";
    $result = mysqli_query($conn, $sql);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['snoEdit'])) {
        $sno = $_POST["snoEdit"];
        $bagid = $_POST['bagid'];
        $donorname = $_POST['donorname'];
        $email = $_POST['email'];
        $mobilenumber = $_POST['mobilenumber'];
        $bloodgroup = $_POST['bloodgroup'];
        $storedate = $_POST['storedate'];
        $expirydate = $_POST['expirydate'];
        // Sql query to be executed
        $sql = "UPDATE `bloodstock` SET `bagid`='$bagid',`donorname`='$donorname',`email`='$email',`mobilenumber`='$mobilenumber',`bloodgroup`='$bloodgroup',`storedate`='$storedate',`expirydate`='$expirydate' WHERE `bloodstock`.`bagid` = '$sno'";
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
    <title>Update Blood Unit Information</title>
</head>

<body>

    <!-- Edit Modal -->
    <div class="modal fade mx-auto" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog bg-dark text-white" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="text-center">Update Blood Unit Information</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="edit-bloodstock.php" method="post" class="item-center mx-5 bg-dark text-white">
                    <input type="hidden" name="snoEdit" id="snoEdit">
                    <div class="mb-3 col-md-6">
                        <label for="exampleInputName1" class="form-label">Bag Id</label>
                        <input type="number" class="form-control" name="bagid" id="bagid">
                    </div>
                    <hr>
                    <div class="mb-3 col-md-6">
                        <label for="exampleInputEmail1" class="form-label">Donor Name</label>
                        <input type="text" class="form-control" name="donorname" id="donorname" aria-describedby="emailHelp">
                    </div>
                    <hr>
                    <div class="mb-3 col-md-6">
                        <label for="exampleInputEmail1" class="form-label">Email Address</label>
                        <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
                    </div>
                    <hr>
                    <div class="mb-3 col-md-6">
                        <label for="exampleInputNumber1" class="form-label">Mobile Number</label>
                        <input type="number" class="form-control" name="mobilenumber" id="mobilenumber">
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
                        <label for="exampleInputDate1" class="form-label">Storing Date</label>
                        <input type="date" class="form-control" name="storedate" id="storedate">
                    </div>
                    <hr>
                    <div class="mb-3 col-md-6">
                        <label for="exampleInputDate1" class="form-label">Expiry Date</label>
                        <input type="date" class="form-control" name="expirydate" id="expirydate">
                    </div>
                    <div class="modal-footer">
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
        <h1 class="text-center">Update Blood Unit Information</h1>
        <hr>
        <div class="m-5">
            <table class="table table-dark table-striped table-hover text-center" id="table">
                <thead>
                    <tr>
                        <th scope="col">Bag Id</th>
                        <th scope="col">Donor Name</th>
                        <th scope="col">Email Address</th>
                        <th scope="col">Mobile Number</th>
                        <th scope="col">Blood Group</th>
                        <th scope="col">Storing Date</th>
                        <th scope="col">Expiry Date</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $sql = "SELECT * FROM `bloodstock` ORDER BY `donorname`";
                    $result = mysqli_query($conn, $sql);

                    if ($result->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo " <tr>
                            <td>" . $row['bagid'] . "</td>
                            <td>" . $row['donorname'] . "</td>
                            <td>" . $row['email'] . "</td>
                            <td>" . $row['mobilenumber'] . "</td>
                            <td>" . $row['bloodgroup'] . "</td>
                            <td>" . $row['storedate'] . "</td>
                            <td>" . $row['expirydate'] . "</td>
                            <td> <button class='edit btn btn-sm btn-danger' id=" . $row['bagid'] . ">Edit</button> <button class='delete btn btn-sm btn-danger' id=d" . $row['bagid'] . ">Delete</button>  </td>
                            </tr>";
                        }
                    } else {
                        echo "<div class=' text-center alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>No results!</strong>
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>×</span>
                            </button>
                        </div>";
                        $conn->close();
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

    <script>
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit");
                tr = e.target.parentNode.parentNode;

                bagid.value = tr.getElementsByTagName("td")[0].innerText;
                donorname.value = tr.getElementsByTagName("td")[1].innerText;
                email.value = tr.getElementsByTagName("td")[2].innerText;
                mobilenumber.value = tr.getElementsByTagName("td")[3].innerText;
                bloodgroup.value = tr.getElementsByTagName("td")[4].innerText;
                storedate.value = tr.getElementsByTagName("td")[5].innerText;
                expirydate.value = tr.getElementsByTagName("td")[6].innerText;

                console.log(bagid.value, donorname.value, email.value, mobilenumber.value, bloodgroup.value, storedate.value, expirydate.value);

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
                    window.location = `edit-bloodstock.php?delete=${sno}`;
                } else {
                    console.log("no");
                }
            })
        })
    </script>
</body>

</html>