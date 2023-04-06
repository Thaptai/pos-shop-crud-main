<?php
include('../dbconnect.php');

$id = $_POST['id'];
$name = $_POST['name'];
$price = $_POST['price'];
$remain = $_POST['remain'];
$category = $_POST['category'];

// random ชื่อรูปภาพเพื่อไม่ให้มันซ้ำ
function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// เช็คว่ามีการส่งรูปมาไหม ถ้ามีก็อัพโหลดไปที่โฟลเดอร์ assets / img
if (isset($_FILES['img'])) {
    $target_dir = '../../assets/img/';
    $img = explode('.', htmlspecialchars(basename($_FILES["img"]["name"])));
    $img = generateRandomString() . '.' . $img[count($img) - 1];
    $target_file = $target_dir . $img;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (!move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
        die("error");
    }
} else $img = $_POST['img'];

$sql = "UPDATE product SET img='$img', name='$name', price='$price', remain=$remain, category='$category' WHERE id=$id";

if (mysqli_query($dbcon, $sql)) echo 'success';
else echo 'error';
