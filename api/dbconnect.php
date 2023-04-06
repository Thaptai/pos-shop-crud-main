<?php
    // เชื่อมต่อ ฐานข้อมูล
    $dbcon = mysqli_connect('localhost', 'root', '', '6212231004');

    if(!$dbcon) die("Can't connect to database.");
?>