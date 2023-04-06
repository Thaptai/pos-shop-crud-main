<?php
    include('../dbconnect.php');

    $id = $_GET['id'];

    $sql = "DELETE FROM category WHERE id=$id";

    if(mysqli_query($dbcon, $sql)) echo 'success';
    else echo 'error';
?>