<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: ../view/login.php');
  exit();
}

require('../Database/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = filter_input(INPUT_POST, 'id');
  $task = filter_input(INPUT_POST, 'task');
  if ($id && !empty($task)) {
    $stmt = $conn->prepare("UPDATE tasks SET task = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$task, $id, $_SESSION['user']['id']]);
    header('Location: index.php');
    exit();
  }
} else {
  $id = filter_input(INPUT_GET, 'id');
  if (!$id) {
    header('Location: index.php');
    exit();
  }
  $stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
  $stmt->execute([$id, $_SESSION['user']['id']]);
  $task = $stmt->fetch();
  if (!$task) {
    header('Location: index.php');
    exit();
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Task - Todo App</title>
  <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
  <div class="container">
    <h1>Edit Task</h1>
    <form method="post">
      <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
      <label for="task">Task:</label>
      <input type="text" name="task" id="task" value="<?php echo $task['task']; ?>" required>
      <button type="submit">Save</button>
    </form>
    <p><a href="index.php">Back to dashboard</a></p>
  </div>
</body>
</html>