<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โปรแกรมคิดเงิน เทพทัย</title>
    <link rel="stylesheet" href="assets/styles/style.css">
    <link rel="stylesheet" href="assets/styles/stock.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <?php session_start();
    if ($_SESSION) {
        include('./api/dbconnect.php');

        $id = $_SESSION['id'];
        $sql = "SELECT * FROM user WHERE id=$id ";
        $arr = mysqli_query($dbcon, $sql);

        function redirect()
        {
            echo "<script>";
            echo "window.location.href='login.php'";
            echo "</script>";
        }


        if (mysqli_num_rows($arr) > 0) {
            while ($row = mysqli_fetch_assoc($arr)) {

                $_SESSION['id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['name'] = $row['name'];
            }
        } else {
            redirect();
        }
    }
    ?>

    <style>
        .commingsoon {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .commingsoon img {
            flex: 1;
        }

        .commingsoon div {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .commingsoon div h1 {
            font-size: 72px;
            background-color: #f3ec78;
            background-size: 100%;
            -webkit-background-clip: text;
            -moz-background-clip: text;
            -webkit-text-fill-color: transparent;
            -moz-text-fill-color: transparent;

            animation: textRGB .5s infinite linear;
        }

        @keyframes textRGB{
            0%{
                background-image: linear-gradient(0deg, red, blue);
            }
            20%{
                background-image: linear-gradient(20deg, blue, green);
            }
            40%{
                background-image: linear-gradient(40deg, green, yellow);
            }
            60%{
                background-image: linear-gradient(60deg, yellow, orange);
            }
            80%{
                background-image: linear-gradient(80deg, orange, purple);
            }
            100%{
                background-image: linear-gradient(90deg, purple, red);
            }
        }
    </style>
</head>

<body>
    <div class="nav-top">
        <div></div>
        <div class="center">
            โปรแกรมคิดเงิน
        </div>
        <div class="right">
            <?php if ($_SESSION) { ?>
                <div class="user">
                    <img src="assets/img/avatar.png" class="avatar" alt="">
                    <span><?php echo $_SESSION['name']; ?></span>
                </div>
                <div class="dropdown-content">
                    <button onclick="edit()">แก้ไขโปรไฟล์</button>

                    <button onclick="logout()">ออกจากระบบ</button>
                </div>
            <?php } else { ?>
                <div>
                    <button onclick="login()" class="login-btn">เข้าสู่ระบบ</button>
                </div>
            <?php } ?>
        </div>
    </div>

    <ul>
        <li><a href="index.php"><i class="fas fa-shopping-cart"></i> &nbsp;หน้าขาย</a></li>
        <li><a href="stock.php"><i class="fas fa-box"></i> &nbsp;สต๊อกสินค้า</a></li>
        <li><a href="category.php"><i class="fas fa-folders"></i> &nbsp;หมวดหมู่สินค้า</a></li>
        <li><a href="history.php"><i class="fas fa-history"></i> &nbsp;ประวัติการขาย</a></li>
        <li class="active"><a href="howto.php"><i class="fas fa-book"></i> &nbsp;คู่มือ</a></li>
    </ul>

    <div id="app" class="commingsoon">
        <img src="assets/img/banner/hello.jpeg" alt="">
        <div>
            <h1>รอก่อนนะจ้ะ</h1>
            <h1>ยังทำไม่เสร็จ</h1>
        </div>
    </div>
</body>

</html>