<?php
    include('./dbconnect.php');

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    if($password != $confirm_password){
        echo "<script>";
        echo "window.location.href='register.php?01'";
        echo "</script>";
    } else{
        $password = md5($password);
        $sql = "INSERT INTO user(name, email, password) VALUES ('$name', '$email', '$password')";

        if(mysqli_query($dbcon, $sql)){
            echo "<script>";
            echo "window.location.href='../login.php'";
            echo "</script>";
        } else{
            echo "<script>";
            echo "window.location.href='../register.php?02'";
            echo "</script>";
        }
    }
?>