<?php
    include('../dbconnect.php');

    $name = $_POST['name'];

    $sql = "INSERT INTO category (name) VALUES ('$name')";

    if(mysqli_query($dbcon, $sql)) echo 'success';
    else echo 'error';
?>