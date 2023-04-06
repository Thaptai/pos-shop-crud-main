<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
</head>
<body>
    <h1>Sign in</h1>
    
    <form action="api/login.php" method="POST">
        <label for="email">Email: </label>
        <input type="text" name="email" id="email"> <br><br>
        <label for="password">Password: </label>
        <input type="password" name="password" id="password"> <br><br>
        <button type="submit">Sign In</button>
        <a href="register.php">สมัครสามาชิก</a>
    </form>
</body>
</html>