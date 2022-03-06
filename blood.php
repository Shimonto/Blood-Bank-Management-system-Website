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

if (!$conn) {
    die("Sorry we failed to connect: " . mysqli_connect_error());
} else {

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['button'])) {
        $bloodid = $_POST['bloodid'];
        $bloodgroup = $_POST['bloodgroup'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $info = $_POST['info'];
        $sql = "INSERT INTO `blood`(`blood_id`, `bloodgroup`, `price`, `info`) VALUES ('$bloodid', '$bloodgroup', '$price', '$info')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $update = true;
        } else {
            $updatefail = true;
        }
        unset($_POST);
    } elseif (isset($_GET['delete'])) {
        $sno = $_GET['delete'];
        $sql = "DELETE FROM `blood` WHERE `blood_id` = '$sno'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $delete = true;
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['button2'])) {
        if (isset($_POST['snoEdit'])) {

            $sno = $_POST["snoEdit"];
            $bloodid = $_POST["bloodidEdit"];
            $bloodgroup = $_POST['bloodgroupEdit'];
            $price = $_POST['priceEdit'];
            $info = $_POST['infoEdit'];

            $sql = "UPDATE `blood` SET `blood_id`='$bloodid', `bloodgroup`= '$bloodgroup',`price`= '$price',`info`= '$info' WHERE `blood_id` = '$sno'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $update = true;
            } else {
                $updatefail = true;
            }
        }
        unset($_POST);
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Blood Information</title>
</head>

<body>
    <div class="modal fade mx-auto" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog bg-dark text-white" role="document">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="editModalLabel">Blood Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="blood.php" method="post" class="item-center mx-5 bg-dark text-white">
                    <input type="hidden" name="snoEdit" id="snoEdit">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">ID</label>
                        <input type="number" class="form-control" name="bloodidEdit" id="bloodidEdit" required>
                    </div>
                    <hr>
                    <div class="mb-3 col-md-4">
                        <label class="form-label">Blood Group</label>
                        <select name="bloodgroupEdit" id="bloodgroupEdit" class="form-select" aria-label="Default select example" required>
                            <option value="" disabled selected>Select Blood Group</option>
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
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Price</label>
                        <input type="number" class="form-control" name="priceEdit" id="priceEdit" required>
                    </div>
                    <hr>
                    <div class="form-floating mb-3 col-md-6">
                        <textarea class="form-control" placeholder="Comment" id="infoEdit" name="infoEdit" style="height: 100px"></textarea>
                        <label for="floatingTextarea2">Information</label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button name="button2" type="submit" class="button2 btn btn-danger">Save changes</button>
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

    <div class="container mt-5 p-5">
        <h1 class="text-center">Add Blood Information</h1>
        <form class="center" action="blood.php" method="post">
            <div class="mb-3 col-md-4">
                <label class="form-label">ID</label>
                <input type="number" class="form-control" name="bloodid" id="bloodid" required>
            </div>
            <hr>
            <div class="mb-3 col-md-4">
                <label class="form-label">Blood Group</label>
                <select name="bloodgroup" id="bloodgroup" class="form-select" aria-label="Default select example" required>
                    <option value="" disabled selected>Select Blood Group</option>
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
                <label class="form-label">Price</label>
                <input type="number" class="form-control" name="price" id="price" required>
            </div>
            <hr>
            <div class="form-floating mb-3 col-md-4">
                <p>Blood Information</p>
                <textarea class="form-control" placeholder="Comment" id="info" name="info" style="height: 100px"></textarea>

            </div>
            <hr>
            <div class="mb-3">
                <button name="button" type="submit" class="button btn btn-outline-danger px-5 py-3">Submit</button>
            </div>
        </form>
    </div>

    <div class="container mt-5 p-5">
        <div class="m-5">
            <table class="table table-light table-striped table-hover text-center" id="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Blood Group</th>
                        <th scope="col">Price</th>
                        <th scope="col">Information</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <h5 class="text-center">Blood Information</h5>
                    <?php
                    $email = $_SESSION['email'];
                    $sql = "SELECT * FROM `blood`";
                    $result = mysqli_query($conn, $sql);
                    if ($result->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "
                        <tr>
                            <td>" . $row['blood_id'] . "</td>
                            <td>" . $row['bloodgroup'] . "</td>
                            <td>" . $row['price'] . "</td>
                            <td>" . $row['info'] . "</td>
                            <td> <button class='edit btn btn-sm btn-danger' id=" . $row['blood_id'] . ">Edit</button> <button class='delete btn btn-sm btn-danger' id=d" . $row['blood_id'] . ">Delete</button>  </td>
                        </tr>";
                        }
                    } else {
                        echo "<div class=' text-center alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>No Results !</strong>
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
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    </script>

    <script>
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit");
                tr = e.target.parentNode.parentNode;
                bloodidEdit.value = tr.getElementsByTagName("td")[0].innerText;
                bloodgroupEdit.value = tr.getElementsByTagName("td")[1].innerText;
                priceEdit.value = tr.getElementsByTagName("td")[2].innerText;
                infoEdit.value = tr.getElementsByTagName("td")[3].innerText;

                console.log(bloodidEdit.value, bloodgroupEdit.value, priceEdit.value, infoEdit.value);

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

                if (confirm("Are you sure you want to delete ?")) {
                    console.log("yes");
                    window.location = `blood.php?delete=${sno}`;
                    // TODO: Create a form and use post request to submit a form
                } else {
                    console.log("no");
                }
            })
        })
    </script>

</body>

</html>