<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: userlogin.php");
    exit;
}
$showAlert = false;
$showError = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_SESSION['email'];
    $bloodgroup = $_POST['bloodgroup'];
    $unit = $_POST['quantity'];
    $price = $_POST['price'];
    $reqdate = date("Y-m-d");
    $expirydate = $_POST['date'];

    // Connecting to the Database
    require 'db.php';

    // $servername = "localhost";
    // $username = "root";
    // $password = "";
    // $database = "bbms";

    // // Create a connection
    // $conn = mysqli_connect($servername, $username, $password, $database);
    // Die if connection was not successful
    if (!$conn) {
        die("Sorry we failed to connect: " . mysqli_connect_error());
    } else {

        $sql = "SELECT COUNT(*) as cnt FROM bloodstock WHERE bloodgroup = '$bloodgroup'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result)['cnt'];

        // $sql = "SELECT SUM(unit) FROM blood-request WHERE bloodgroup = '$bloodgroup'";
        // $result = mysqli_query($conn, $sql);
        // $row = mysqli_fetch_assoc($result)['cnt'];
        // echo "$row";
        if ($row < $unit) {
            $showError = "Not Enough Blood Bag!!";
        } else {
            $sql = "INSERT INTO `blood-request`(`user_mail`, `blood_group`, `unit`, `price`, `req_date`, `req_expire_date`, `status`) VALUES  ('$email','$bloodgroup','$unit','$price','$reqdate','$expirydate', 'unpaid')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $showAlert = true;
            } else {
                $showError = "failed to Send Blood Request !!";
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

    <title>Booking</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php require 'navbar.php' ?>

    <?php
    if ($showAlert) {
        echo ' <div class="text-center alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Blood Request successfully !!.
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

    <div class="container mt-5 p-5 ">
        <h1 class="text-center">Request for Blood Bag</h1>
        <form action="booking.php" method="post" class="item-center">
            <input type="hidden" name="mode" value="PinRequest" />
            <div class="mb-3 col-md-4">
                <label for="exampleInputDate1" class="form-label">Blood Group</label>
                <select name="bloodgroup" id="bloodgroup" class="form-select" aria-label="Default select example" onchange="blood(this.value)" required>
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
                <label for="exampleInputNumber1" class="form-label">Quantity</label>
                <select class="form-select" name="quantity" id="quantity" onchange="calculateAmount(this.value)" required>
                    <!-- <option value="" disabled selected>Quantity</option> -->
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                </select>
            </div>
            <div class="mb-3 col-md-1">
                <label for="exampleInputNumber1" class="form-label">Price in TK</label>
                <input type="number" class="form-control" name="price" id="price" readonly>
            </div>
            <hr>
            <div class="mb-3 col-md-4">
                <label for="exampleInputDate1" class="form-label">date of collecting</label>
                <input type="date" class="form-control" name="date" id="date" required>
            </div>
            <hr>
            <div class="mb-3">
                <button type="submit" class="btn btn-outline-danger px-5 py-3">Submit</button>
            </div>
            <hr>
        </form>
    </div>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "bbms";

    // Create a connection
    $conn = mysqli_connect($servername, $username, $password, $database);
    $sql = "SELECT * FROM `blood`";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {

        while ($row = mysqli_fetch_assoc($result)) {

            if ($row['bloodgroup'] == 'B+') {
                $Bplus = $row['price'];
            } elseif ($row['bloodgroup'] == 'B-') {
                $Bminus = $row['price'];
            } elseif ($row['bloodgroup'] == 'A+') {
                $Aplus = $row['price'];
            } elseif ($row['bloodgroup'] == 'A-') {
                $Aminus = $row['price'];
            } elseif ($row['bloodgroup'] == 'AB+') {
                $ABplus = $row['price'];
            } elseif ($row['bloodgroup'] == 'AB-') {
                $ABminus = $row['price'];
            } elseif ($row['bloodgroup'] == 'O+') {
                $Oplus = $row['price'];
            } elseif ($row['bloodgroup'] == 'O-') {
                $Ominus = $row['price'];
            }
        }
    }
    ?>

    <script>
        function blood(val) {
            var tot_price = 0;
            var x = document.getElementById("quantity").value;
            if (val == 'B+') {
                var tot_price = x * <?php echo $Bplus; ?>;
            } else if (val == 'B-') {
                var tot_price = x * <?php echo $Bminus; ?>;
            } else if (val == 'A+') {
                var tot_price = x * <?php echo $Aplus; ?>;
            } else if (val == 'A-') {
                var tot_price = x * <?php echo $Aminus; ?>;
            } else if (val == 'AB+') {
                var tot_price = x * <?php echo $ABplus; ?>;
            } else if (val == 'AB-') {
                var tot_price = x * <?php echo $ABminus; ?>;
            } else if (val == 'O+') {
                var tot_price = x * <?php echo $Oplus; ?>;
            } else if (val == 'O-') {
                var tot_price = x * <?php echo $Ominus; ?>;
            }

            /*display the result*/
            var divobj = document.getElementById('price');
            divobj.value = tot_price;
        }

        function calculateAmount(val) {
            var x = document.getElementById("bloodgroup").value;
            if (x == 'B+') {
                var tot_price = val * <?php echo $Bplus; ?>;
            } else if (x == 'B-') {
                var tot_price = val * <?php echo $Bminus; ?>;
            } else if (x == 'A+') {
                var tot_price = val * <?php echo $Aplus; ?>;
            } else if (x == 'A-') {
                var tot_price = val * <?php echo $Aminus; ?>;
            } else if (x == 'AB+') {
                var tot_price = val * <?php echo $ABplus; ?>;
            } else if (x == 'AB-') {
                var tot_price = val * <?php echo $ABminus; ?>;
            } else if (x == 'O+') {
                var tot_price = val * <?php echo $Oplus; ?>;
            } else if (x == 'O-') {
                var tot_price = val * <?php echo $Ominus; ?>;
            }
            /*display the result*/
            var divobj = document.getElementById('price');
            divobj.value = tot_price;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>