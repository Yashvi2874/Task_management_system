<?php
session_start();
?>
  <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Manager</title>
</head>
<body style="margin: 0; font-family: Arial, sans-serif; padding: 20px; background-color:  rgb(35, 50, 64);">
<?php include 'header.php'; ?>
    <div style="text-align: center; padding: 10px; margin-bottom: 50px;">
        <h2  style="color: white; font-size: 25px;">Welcome!</h2>
        <p style="color: white; font-size: 18px; margin-bottom: -20px; margin-top: -10px;">Organize your tasks efficiently and boost your productivity!</p>
        <div style="margin: 40px auto; max-width: 600px; background: #2c3e50; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <h2 style="color: white;">Get Started</h2>
            <p style="color: white; margin-bottom: 0px;">New to Task Manager? Register now to start managing your tasks effectively.</p>
            <a href="register.php" style="display: inline-block; font-weight: 700; background-color: #2980b9; color: white; padding: 10px 20px; text-decoration: none; margin: 10px; border-radius: 5px;">Register Now</a>
            <p style="color: white; margin-top: 20px; margin-bottom: 0px;">Already have an account?</p>
            <a href="login.php" style="display: inline-block; font-weight: 700; background-color: #2980b9; color: white; padding: 10px 20px; text-decoration: none; margin: 10px; border-radius: 5px;">Login</a>
        </div>  
        <div style="margin: -20px auto; max-width: 800px;">
            <h3 style="color: white; margin-bottom: 20px;">Features</h3>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px;">
                <div style="background: #2c3e50; padding: 15px; border-radius: 5px;">
                    <h4 style="color: white;">Task Organization</h4>
                    <p style="color: white;">Create and organize tasks efficiently</p>
                </div>
                <div style="background: #2c3e50; padding: 15px; border-radius: 5px;">
                    <h4 style="color: white;">Priority Setting</h4>
                    <p style="color: white;">Set priorities for your tasks</p>
                </div>
                <div style="background: #2c3e50; padding: 15px; border-radius: 5px;">
                    <h4 style="color: white;">Progress Tracking</h4>
                    <p style="color: white;">Track your task completion</p>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>