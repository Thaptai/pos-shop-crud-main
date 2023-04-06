<?php
    include('../dbconnect.php');

    $id = $_GET['id'];
    $sql = "SELECT * FROM history WHERE id = $id";
    $result = mysqli_query($dbcon, $sql);

    while($row = mysqli_fetch_assoc($result)){
        var_dump(json_encode($row));
    }
?>