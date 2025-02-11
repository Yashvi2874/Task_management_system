<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $login_input = trim($_POST["login"]);
    $password = trim($_POST["password"]);

    if (empty($login_input) || empty($password)) {
        $error = "Both fields are required.";
    } else {
        $stmt = $conn->prepare("SELECT id, username, email, password FROM users2 WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $login_input, $login_input);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $username, $email, $hashed_password);
            $stmt->fetch();
            
            if (password_verify($password, $hashed_password)) {
                $_SESSION["user_id"] = $id;
                $_SESSION["username"] = $username;
                $_SESSION["email"] = $email;

                session_regenerate_id(true);  
          
                setcookie(session_name(), session_id(), [  
                    'expires' => time() + 3600,    
                    'path' => '/',    
                    'secure' => true,    
                    'httponly' => true,    
                    'samesite' => 'Strict',    
                ]); 

                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid credentials.";
            }
        } else {
            $error = "No account found.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Task manager</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body style="margin: 20px; font-family: Arial, sans-serif; padding: 50px; background-color: rgb(35, 50, 64);">
    <?php include 'header.php'; ?>
    <div style="max-width: 400px; margin: 100px auto; background-color:  #2c3e50; padding: 30px; box-shadow: 0 0 10px rgba(0,0,0,0.1); border-radius: 5px;">
        <h2 style="text-align: center; color: white;">Login</h2>
        <form method="post" style="display: flex; flex-direction: column;">
        <input type="text" name="login" placeholder="Username or Email" style="background:rgb(63, 84, 106); color: white; margin: 10px 0; padding: 12px 0 12px 5px; border: 1px solid #ddd; border-radius: 4px;">
        <input type="password" name="password" placeholder="Password" required style="background:rgb(63, 84, 106); color: white; margin: 10px 0; margin-bottom: 20px; padding: 12px 0 12px 5px; border: 1px solid #ddd; border-radius: 4px;">
            <button type="submit" style="background-color: #2980b9; color: white; padding: 12px; border: none; cursor: pointer; border-radius: 4px; font-weight: 700;">Login</button>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        </form>
        <p style="text-align: center; margin-top: 10px; color: white;">
            Don't have an account? 
            <a href="register.php" target="main" style="color: #2980b9; text-decoration: none;">Register here</a>
        </p>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>