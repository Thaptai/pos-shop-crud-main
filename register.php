<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <h1>Sign Up</h1>
    
    <form action="api/register.php" method="POST">
        <label for="name">ชื่อ: </label>
        <input type="text" name="name" id="name"> <br><br>
        <label for="email">อีเมล: </label>
        <input type="text" name="email" id="email"> <br><br>
        <label for="password">รหัสผ่าน: </label>
        <input type="password" name="password" id="password"> <br><br>
        <label for="confirm-password">ยืนยันรหัสผ่าน: </label>
        <input type="password" name="confirm-password" id="confirm-password"> <br><br>
        <button type="submit">Sign Up</button>
    </form>

    <script>
        let query = window.location.search;

        if(query){
            query = query.split('?')[1];
            if(query == '01') alert('รหัสผ่านไม่ตรงกัน');
            else if(query == '02') alert('สมัครสมาชิกล้มเหลว');
        }
    </script>
</body>
</html>