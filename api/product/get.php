<?php
    include('../dbconnect.php');

    $sql = "SELECT * FROM product";
    $result = mysqli_query($dbcon, $sql);

    while($product = mysqli_fetch_assoc($result)){
        // var_dump ส่งข้อมูลสินค้าที่ได้มาจากฐานข้อมูลไปให้หน้าบ้าน
        var_dump(json_encode($product));
    }
?>