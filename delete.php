<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bbms";

$conn = mysqli_connect($servername, $username, $password, $database);
if (isset($_GET['delete'])) {
        $sno = $_GET['delete'];
        echo $sno;
        $sql = "DELETE FROM `blood` WHERE `bloodgroup` = '$sno'";
        $result = mysqli_query($conn, $sql);
        
}
