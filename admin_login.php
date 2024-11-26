<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/su.css">
</head>
<body>
    <div class="container">
        <h1><img src="img/admin-icon.png" alt="admin-icon"></h1>
        <form method="post" action="admin_lAction.php">
            <div class="form-group">
                <input type="text" name="user" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" name="pass" placeholder="Password" required>
            </div>
            <br>
            <div class="form-group">
                <button href="" type="submit">Login</button>
            </div>
        </form>
    </div>
</body>
</html>