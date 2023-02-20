<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: ../view/login.php');
  exit();
}

require('../Database/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $task = filter_input(INPUT_POST, 'task');
  if (!empty($task)) {
    $stmt = $conn->prepare("INSERT INTO tasks (task, user_id) VALUES (?, ?)");
    $stmt->execute([$task, $_SESSION['user']['id']]);
    header('Location: index.php');
    exit();
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Create Task - Todo App</title>
  <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
  <div class="container">
    <h1>Create Task</h1>
    <form method="post">
      <label for="task">Task:</label>
      <input type="text" name="task" id="task" required>
      <button type="submit">Create</button>
    </form>
    <p><a href="index.php">Back to dashboard</a></p>
  </div>
</body>
</html>
