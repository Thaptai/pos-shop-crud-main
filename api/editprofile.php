<?php

include('./dbconnect.php');

session_start();
$name = $_POST['name'];
$id = $_SESSION['id'];

$sql = "UPDATE user SET name='$name' WHERE id=$id";
if (mysqli_query($dbcon, $sql)) {
    echo "<script>";
    echo "window.location.href='../index.php'";
    echo "</script>";
} else {
    echo "<script>";
    echo "window.location.href='../editprofile.php'";
    echo "</script>";
}
