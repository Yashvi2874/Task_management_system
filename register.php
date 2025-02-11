<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);
    $contact = trim($_POST["contact"]);

    if (empty($username) || empty($name) || empty($email) || empty($password) || empty($confirm_password) || empty($contact)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (!preg_match("/^[a-zA-Z0-9_]{5,20}$/", $username)) {
        $error = "Username must be 5-20 characters long and can contain letters, numbers, and underscores.";
    } elseif (!preg_match("/^[0-9]{10}$/", $contact)) {
        $error = "Invalid contact number. It should be 10 digits.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users2 WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Username or Email already exists. Please use a different one.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO users2 (username, name, email, password, contact) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $username, $name, $email, $hashed_password, $contact);
            
            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                $error = "Error while registering. Please try again.";
            }
        }
        
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Task Manager</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body style="margin: 40px; font-family: Arial, sans-serif; padding: 0px; background-color: rgb(35, 50, 64);">
<?php include 'header.php'; ?>
    <div style="max-width: 500px; margin: 30px auto; background-color:  #2c3e50; padding: 20px 50px; box-shadow: 0 0 10px rgba(0,0,0,0.1); border-radius: 5px;">
        <h2 style="text-align: center; color: white;">Register</h2>
        <form method="POST" style="display: flex; flex-direction: column;">
            <input type="text" name="username" placeholder="Username" required style="background:rgb(63, 84, 106); margin: 10px 0; padding: 12px 0 12px 5px; border: 1px solid white; border-radius: 4px;">
            <input type="text" name="name" placeholder="Full Name" required style="background:rgb(63, 84, 106); margin: 10px 0; padding: 12px 0 12px 5px; border: 1px solid white; border-radius: 4px;">
            <input type="email" name="email" placeholder="Email" required style="background:rgb(63, 84, 106); margin: 10px 0; padding: 12px 0 12px 5px; border: 1px solid white; border-radius: 4px;">
            <input type="password" name="password" placeholder="Password" required style="background:rgb(63, 84, 106); margin: 10px 0; padding: 12px 0 12px 5px; border: 1px solid white; border-radius: 4px;">
            <input type="password" name="confirm_password" placeholder="Confirm Password" required style="background:rgb(63, 84, 106); margin: 10px 0; padding: 12px 0 12px 5px; border: 1px solid white; border-radius: 4px;">
            <input type="text" name="contact" placeholder="Contact Number" required style="background:rgb(63, 84, 106); margin: 10px 0; padding: 12px 0 12px 5px; border: 1px solid white; border-radius: 4px;">
            <button type="submit" style="background-color: #2980b9; color: white; padding: 12px 0 12px 5px; border: none; cursor: pointer; border-radius: 4px; font-weight: 700;">Register</button>
            <?php if ($error): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
        </form>
        <p style="text-align: center; margin-top: 20px; color: #7f8c8d;">
            Already have an account? 
            <a href="login.php" target="main" style="color: #2980b9; text-decoration: none;">Login here</a>
        </p>
    </div>
</body>
<?php include 'footer.php'; ?>
</html>