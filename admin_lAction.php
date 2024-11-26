<?php
session_start();
include "connect.php";
if (isset($_POST['user']) && isset($_POST['pass'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $user = validate($_POST['user']);
    $pass = validate($_POST['pass']);
    if (empty($user)) {
        header("Location: index.php?error=username is required");
        exit();
    } else if (empty($pass)) {
        header("Location: index.php?error=password is required");
        exit();
    } else {       
        $user = strtolower($user);
        $pass = strtolower($pass);
        $sql = "SELECT * FROM tbladmin WHERE username = '$user' AND password = '$pass'";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['username'] === $user && $row['password'] === $pass) {
                echo "Logged In!";
                $_SESSION['username'] = $row['username'];
                $_SESSION['id'] = $row['id'];
                header("Location: admin_dashboard.php");
                exit();
            } else {
                header("Location: index.php?error=incorrect user or pass");
                exit();
            }
        } else {
            header("Location: index.php?error=incorrect user or pass!");
            exit();
        }
    }
} else {
    header("Location: index.php");
    exit();
}
