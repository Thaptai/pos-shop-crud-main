<?php

include('./dbconnect.php');

$email = $_POST['email'];
$password = $_POST['password'];

$password = md5($password);
$sql = "SELECT * FROM user WHERE email='$email' AND password='$password'";
$arr = mysqli_query($dbcon, $sql);

function redirect() {
    echo "<script>";
    echo "window.location.href='../login.php'";
    echo "</script>";
}

if ($arr) {
    if (mysqli_num_rows($arr) > 0) {
        while ($row = mysqli_fetch_assoc($arr)) {
            session_start();
            $_SESSION['id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['name'] = $row['name'];

            echo "<script>";
            echo "window.location.href='../index.php'"; 
            echo "</script>";
        }
    } else {
        redirect();
    }
} else {
    redirect();
}
