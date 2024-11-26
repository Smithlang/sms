<?php
session_start();

include "connect.php";

if ($_SERVER["REQUEST_METHOD"]== "POST") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $contact = $_POST['contact'];    
    $username = strtolower($_POST['username']);
    $password = strtolower($_POST['password']);

    $check_username_query = "SELECT * FROM tbladmin WHERE username = '$username'";
    $result = mysqli_query($con, $check_username_query);

    if (mysqli_num_rows($result) > 0) {
        echo '<script>alert("Ouch HAHAHA! Username already taken. Please choose a different username.")</script>';
        echo '<script>window.location.href = "signup.php"</script>';
    } else {      
        $insert_query = "INSERT INTO tbladmin (fname, lname, contact, username, password) VALUES
        ('$fname', '$lname','$contact','$username', '$password')";
        if(mysqli_query($con,$insert_query)) {               
            header("Location: register.php");
            exit();
        } else {
            echo "ERROR: Could not able to execute $insert_query. " . mysqli_error($con);
        } 
    }
} else {
    header("Location: signup.php");
    exit();
}

