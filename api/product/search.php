<?php
    include('../dbconnect.php');

    $text = $_GET['text'];
    $category = $_GET['category'];

    // die($category);

    $sql = "SELECT * FROM product WHERE name LIKE '%$text%'";
    if($category != '') $sql .= " AND category='$category'";
    $result = mysqli_query($dbcon, $sql);
    // var_dump($result);

    while($row = mysqli_fetch_assoc($result)){
        var_dump(json_encode($row));
    }
?>