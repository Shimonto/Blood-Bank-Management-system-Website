<?php
session_start();
$showAlert = false;
$error = false;
$codeerror = false;

$searchemail = true;
$changepass = false;
$verifycode = false;

// Connecting to the Database
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['button3'])) {
    // Die if connection was not successful
    $email = $_SESSION['email'];
    $enteredcode = $_POST['number'];
    $code = $_SESSION['code'];

    if ($enteredcode == $code) {
        $changepass = true;
        $searchemail = false;
    } else {
        $codeerror = true;
        $changepass = false;
        $searchemail = false;
        $verifycode = true;
    }

    unset($_POST);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['button2'])) {
    // Die if connection was not successful
    if (!$conn) {
        die("Sorry we failed to connect: " . mysqli_connect_error());
    } else {
        $email = $_SESSION['email'];
        $pass = $_POST['pass'];
        $hash = password_hash($pass, PASSWORD_DEFAULT);

        if (isset($_SESSION['acp'])) {
            $sql = "UPDATE admin SET pass = '$hash' WHERE admin.email = '$email'";
        }
        if (isset($_SESSION['ucp'])) {
            $sql = "UPDATE user SET pass = '$hash' WHERE user.email = '$email'";
        }

        $result = mysqli_query($conn, $sql);
        if ($result) {
            $showAlert = true;
        }
    }
    unset($_POST);
}

//search mail
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['button1'])) {
    // Die if connection was not successful
    if (!$conn) {
        die("Sorry we failed to connect: " . mysqli_connect_error());
    } else {
        $email = $_POST['email'];

        if (isset($_SESSION['acp'])) {
            $sql = "Select * from admin where email='$email'";
        }
        if (isset($_SESSION['ucp'])) {
            $sql = "Select * from user where email='$email'";
        }

        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if ($num == 1) {
            $searchemail = false;
            $verifycode = true;

            $_SESSION['email'] = $email;
            $code =  random_int(10000, 100000);
            $_SESSION['code'] = $code;

            $subject = "Reset Your Password";
            $body = "Use this code $code to reset your password.";
            $headers = "From: mz.shanto6997@gmail.com";

            mail($email, $subject, $body, $headers);

        } else {
            $error = "No user found !!";
        }
    }
    unset($_POST);
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Change Password</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php require 'navbar.php' ?>

    <?php
    if ($codeerror) {
        echo ' <div class="text-center alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> invalid Verification Code.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div> ';
    }

    if ($error) {
        echo ' <div class="text-center alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> ' . $error . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div> ';
    }
    if ($showAlert) {
        $email = $_SESSION['email'];
        echo ' <div class="text-center alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success! </strong>' . $_SESSION['email'] . ' Your Password changed !!.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div> ';
    }

    if ($changepass) {
        echo '<div class="container mt-5 p-5 ">
        <h1 class="text-center">Change Your Password</h1>
        <form action="changepass.php" method="post">
            <hr>
            <div class="mb-3 col-md-6">
                <label for="exampleInputPassword1" class="form-label">Enter New Password</label>
                <input type="password" class="form-control" name="pass" id="exampleInputPassword1">
            </div>
            <button name="button2" type="submit" class="button2 py-3 mt-4 px-5 btn btn-outline-danger">Submit</button>
        </form>
        </div>';
    }
    if ($verifycode) {
        echo '<div class="container mt-5 p-5 ">
        <h1 class="text-center">Code Verification</h1>
        <hr>
        <div class="mb-3 col-md-6 alert alert-warning" role="alert">
            <strong>Verification code has sended to ' . $_SESSION['email'] . '.</strong>
        </div>
        <form action="changepass.php" method="post">
            <div class="mb-3 col-md-6">
                <label for="exampleInputPassword1" class="form-label">Enter Verification Code</label>
                <input type="number" class="form-control" name="number" id="number">
            </div>
            <button name="button3" type="submit" class="button3 py-3 mt-4 px-5 btn btn-outline-danger">Submit</button>
        </form>
        </div>';
    }
    if ($searchemail) {
        echo '<div class="container mt-5 p-5 ">
        <h1 class="text-center">Search email address to set new password</h1>
        <hr>
        <div class="mb-3 col-md-6 alert alert-warning" role="alert">
        <strong>We will send a verification code to your email.</strong>
        </div>
        <form action="changepass.php" method="post">
            <div class="mb-3 col-md-6">
                <label for="exampleInputEmail1" class="form-label">Email Address</label>
                <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
            </div>
            <button name="button1" type="submit" class="button1 py-3 mt-4 px-5 btn btn-outline-danger">Submit</button>
        </form>
    </div>';
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>