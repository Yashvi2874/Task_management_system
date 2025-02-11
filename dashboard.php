<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "users");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["username"];
$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_task"])) {
    $title = mysqli_real_escape_string($conn, $_POST["title"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);
    $priority = $_POST["priority"];
    $due_date = $_POST["due_date"];

    $sql = "INSERT INTO tasks (user_id, title, description, priority, due_date) VALUES ('$user_id', '$title', '$description', '$priority', '$due_date')";
    mysqli_query($conn, $sql);

    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mark_complete"])) {
    $task_id = $_POST["task_id"];
    mysqli_query($conn, "DELETE FROM tasks WHERE id = '$task_id'");
    header("Location: dashboard.php");
    exit();
}

$tasks = mysqli_query($conn, "SELECT * FROM tasks WHERE user_id = '$user_id' ORDER BY due_date ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - My Tasks</title>
    <?php include 'header.php'; ?>
</head>
<body style="font-family: Arial, sans-serif; padding: 20px;">
    <div style="max-width: 800px; margin: auto; background-color:rgb(35, 50, 64); padding: 20px; border-radius: 5px;">
        <h2 style="color: white;">My Tasks, <?php echo htmlspecialchars($username); ?>!</h2>

        <div style="background: #2c3e50; padding: 5px 20px; border-radius: 5px; margin-bottom: 20px;">
            <h3 style="color: white;">Add New Task</h3>
            <form method="post">
                <input type="text" name="title" placeholder="Task Title" required style="background:rgb(63, 84, 106); color: white; width: 100%; padding: 12px 0 12px 5px; margin: 5px 0; border: 1px solid #ccc; border-radius: 4px;"><br>
                <textarea name="description" placeholder="Task Description" required style="background:rgb(63, 84, 106); color: white; width: 100%; padding: 12px 0 12px 5px; margin: 5px 0; border: 1px solid #ccc; border-radius: 4px; height: 80px;"></textarea><br>
                <select name="priority" required style="background:rgb(63, 84, 106); color: white; width: 101%; padding: 12px 0 12px 5px; margin: 5px 0; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="High">High Priority</option>
                    <option value="Medium">Medium Priority</option>
                    <option value="Low">Low Priority</option>
                </select><br>
                <input type="date" name="due_date" required style="background:rgb(63, 84, 106); color: white; width: 100%; padding: 12px 0 12px 5px; margin: 5px 0; border: 1px solid #ccc; border-radius: 4px;"><br>
                <button type="submit" name="add_task" style="background-color: #209350; color: white; padding: 12px; margin: 5px 0; border: none; border-radius: 4px; cursor: pointer; font-weight: 700;">Add Task</button>
            </form>
        </div>

        <h3 style="color: white; ">Task List</h3>
        <?php while ($task = mysqli_fetch_assoc($tasks)): ?>
            <div style="background: #2c3e50; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 5px solid <?php echo ($task['priority'] == 'High') ? 'red' : (($task['priority'] == 'Medium') ? 'orange' : 'green'); ?>;">
                <strong><?php echo htmlspecialchars($task['title']); ?></strong>
                <span style="float: right; padding: 5px 10px; color: white; font-weight: bold; border-radius: 3px; background: <?php echo ($task['priority'] == 'High') ? 'red' : (($task['priority'] == 'Medium') ? 'orange' : 'green'); ?>;">
                    <?php echo htmlspecialchars($task['priority']); ?>
                </span>
                <p style="margin: 5px 0;"><?php echo htmlspecialchars($task['description']); ?></p>
                <p style="margin: 5px 0; color: white;">Due: <?php echo htmlspecialchars($task['due_date']); ?></p>
                <form method="post" style="margin-top: 10px;">
                    <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                    <button type="submit" name="mark_complete" style="background-color: #209350; color: white; padding: 8px; border: none; border-radius: 4px; cursor: pointer;">Mark Complete</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>