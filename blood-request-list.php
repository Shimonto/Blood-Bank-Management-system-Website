<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: home.php");
    exit;
}
$update = false;
$updatefail = false;
$delete = false;

require 'db.php';
// Die if connection was not successful
if (!$conn) {
    die("Sorry we failed to connect: " . mysqli_connect_error());
} else {

    if (isset($_GET['delete'])) {
        $sno = $_GET['delete'];
        echo $sno;
        $sql = "DELETE FROM `blood-request` WHERE `booking_id` = '$sno'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $delete = true;
        }
    }

    if (isset($_GET['pay'])) {
        $sno = $_GET['pay'];
        $sql = "UPDATE `blood-request` SET `status`= 'paid' WHERE `booking_id` = '$sno'";
        $result = mysqli_query($conn, $sql);

        $sql = "SELECT * FROM `blood-request` where booking_id = '$sno'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $bloodgroup = $row['blood_group'];
        $email = $row['user_mail'];
        $unit = $row['unit'];
        $price = $row['price'];
        $date = date("Y-m-d");

        $sql = "INSERT INTO `bill`(`bloodgroup`, `email`,`unit`, `price`, `date`) VALUES  ('$bloodgroup','$email','$unit','$price','$date')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $update = true;
        } else {
            $updatefail = true;
            // echo "<script>alert('Could not update the record successfully !!')</script>";
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['snoEdit'])) {
            // Update the record
            $sno = $_POST['snoEdit'];
            $bookingid = $_POST['bookingid'];
            $mail = $_POST['email'];
            $bloodgroup = $_POST['bloodgroup'];
            $unit = $_POST['quantity'];
            $reqdate = $_POST['reqdate'];
            $expirydate = $_POST['expdate'];
            $payment = $_POST['pay'];
            // Sql query to be executed
            $sql = "UPDATE `blood-request` SET `booking_id`= '$bookingid', `user_mail`= '$mail', `blood_group`= '$bloodgroup',`unit`= '$unit',`req_date`= '$reqdate', `req_expire_date`= '$expirydate', `status`= '$payment' WHERE `booking_id` = '$sno'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $update = true;
            } else {
                $updatefail = true;
                // echo "<script>alert('Could not update the record successfully !!')</script>";
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
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <title>Blood Request List</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
</head>

<body>


    <!-- Edit Modal -->
    <div class="modal fade mx-auto" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog bg-dark text-white" role="document">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="editModalLabel">Update booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="blood-request-list.php" method="post" class="item-center mx-5 bg-dark text-white">
                    <input type="hidden" name="snoEdit" id="snoEdit">
                    <div class="mb-3 col-md-6">
                        <label for="exampleInputName1" class="form-label">Booking Id</label>
                        <input type="number" class="form-control" name="bookingid" id="bookingid">
                    </div>
                    <hr>
                    <div class="mb-3 col-md-6">
                        <label for="exampleInputEmail1" class="form-label">Email Address</label>
                        <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
                    </div>
                    <hr>
                    <div class="mb-3 col-md-4">
                        <label for="exampleInputDate1" class="form-label">Blood Group</label>
                        <select name="bloodgroup" id="bloodgroup" class="form-select" aria-label="Default select example">
                            <option value="A+">A+</option>
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
                    <div class="mb-3 col-md-4">
                        <label for="exampleInputNumber1" class="form-label">Quantity</label>
                        <select class="form-select" name="quantity" id="quantity" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                        </select>
                    </div>
                    <hr>
                    <div class="mb-3 col-md-6">
                        <label for="exampleInputDate1" class="form-label">Request date</label>
                        <input type="date" class="form-control" name="reqdate" id="reqdate">
                    </div>
                    <hr>
                    <div class="mb-3 col-md-6">
                        <label for="exampleInputDate1" class="form-label">Request expire date</label>
                        <input type="date" class="form-control" name="expdate" id="expdate">
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="exampleInputDate1" class="form-label">Payment Status</label>
                        <select name="pay" id="pay" class="form-select" aria-label="Default select example">
                            <option value="paid">Paid</option>
                            <option value="unpaid">Unpaid</option>
                        </select>
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
        <h1 class="text-center">Blood Bag Requests</h1>
        <hr>
        <div class="m-5">
            <table class="table table-dark text-center" id="table">
                <thead>
                    <tr>
                        <th scope="col">Booking ID</th>
                        <th scope="col">Email Address</th>
                        <th scope="col">Blood Group</th>
                        <th scope="col">Unit</th>
                        <th scope="col">Request Date</th>
                        <th scope="col">Request Expire date</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $sql = "SELECT * FROM `blood-request` ORDER BY `booking_id`";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo " <tr>
                        <td>" . $row['booking_id'] . "</td>
                        <td>" . $row['user_mail'] . "</td>
                        <td>" . $row['blood_group'] . "</td>
                        <td>" . $row['unit'] . "</td>
                        <td>" . $row['req_date'] . "</td>
                        <td>" . $row['req_expire_date'] . "</td>"; ?>
                    <?php if ($row['status'] == 'unpaid') {
                            echo "<td class='bg-danger'>" . $row['status'] . "</td>";
                        } elseif ($row['status'] == 'paid') {
                            echo "<td class='bg-success'>" . $row['status'] . "</td>";
                        }
                        echo "<td><button class='edit btn btn-danger m-1' id=" . $row['booking_id'] . ">Edit</button> <button class='delete btn btn-danger m-1' id=d" . $row['booking_id'] . ">Delete Booking</button><a type='submit' name='submit' class='payment btn btn-danger' id=a" . $row['booking_id'] . ">Confirm Payment</a></td>

                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <hr>
    </div>
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
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit");
                tr = e.target.parentNode.parentNode;
                bookingid.value = tr.getElementsByTagName("td")[0].innerText;
                email.value = tr.getElementsByTagName("td")[1].innerText;
                bloodgroup.value = tr.getElementsByTagName("td")[2].innerText;
                quantity.value = tr.getElementsByTagName("td")[3].innerText;
                reqdate.value = tr.getElementsByTagName("td")[4].innerText;
                expdate.value = tr.getElementsByTagName("td")[5].innerText;
                pay.value = tr.getElementsByTagName("td")[6].innerText;

                console.log(bookingid.value, email.value, bloodgroup.value, quantity.value, reqdate.value, expdate.value, pay.value);

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

                if (confirm("Are you sure you want to cancel this booking ?")) {
                    console.log("yes");
                    window.location = `edit-booking.php?delete=${sno}`;
                    // TODO: Create a form and use post request to submit a form
                } else {
                    console.log("no");
                }
            })
        })

        payment = document.getElementsByClassName('payment');
        Array.from(payment).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit");
                sno = e.target.id.substr(1);
                console.log(sno);

                if (confirm("Are you sure you want to confurm this payment?")) {
                    console.log("yes");
                    window.location = `blood-request-list.php?pay=${sno}`;
                    // TODO: Create a form and use post request to submit a form
                } else {
                    console.log("no");
                }
            })
        })
    </script>
</body>

</html>