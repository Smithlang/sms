<?php
$sname="localhost";
$uname="root";
$pword="";
$database="studentms";

$con = mysqli_connect($sname, $uname, $pword, $database);
if (!$con) {
    echo "Connection Failed";
}