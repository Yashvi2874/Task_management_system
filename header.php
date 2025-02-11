<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Header</title>
</head>
<body style="margin: 0; background-color: #2c3e50; color: white; padding: 10px;">
    <h1 style="padding-top: 0; margin: 0; color: white;  text-align: center;">Task Management System</h1>
    <nav style="padding: 10px; text-align: center;">
        <a href="main.php" style="color: white; margin: 0 10px; text-decoration: none;">Home</a> 
        <?php if (isset($_SESSION["user_id"])): ?>
            <a href="dashboard.php" style="color: white; margin: 0 10px; text-decoration: none;">My Tasks</a>
            <a href="logout.php" style="color: white; margin: 0 10px; text-decoration: none;">Logout</a>
        <?php else: ?>
            <a href="login.php" style="color: white; margin: 0 10px; text-decoration: none;">Login</a>
            <a href="register.php" style="color: white; margin: 0 10px; text-decoration: none;">Register</a>
        <?php endif; ?>
    </nav>
</body>
</html>
