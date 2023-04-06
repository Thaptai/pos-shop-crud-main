<?php
    include('../dbconnect.php');

    $id = $_POST['id'];
    $name = $_POST['name'];

    $sql = "UPDATE category SET name='$name' WHERE id=$id";

    if(mysqli_query($dbcon, $sql)) echo 'success';
    else echo 'error';
?>