<?php
$dateOfBirth = "1997-09-16";
$today = date("Y-m-d");
$diff = date_diff(date_create($dateOfBirth), date_create($today));
echo 'Age is '.$diff->format('%y');
echo "$today";
?>