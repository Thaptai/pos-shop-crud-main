<?php
    include('../dbconnect.php');

    $sql = "SELECT * FROM category";
    $result = mysqli_query($dbcon, $sql);

    while($row = mysqli_fetch_assoc($result)){
        var_dump(json_encode($row));
    }
?>