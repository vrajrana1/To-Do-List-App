<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: ../view/login.php');
  exit();
}

require('../Database/db.php');

$stmt = $conn->prepare("SELECT id, task, completed FROM tasks WHERE user_id = ? ORDER BY id DESC");
$stmt->execute([$_SESSION['user']['id']]);
$tasks = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['task'])) {
    $task = filter_input(INPUT_POST, 'task');
    if (!empty($task)) {
      $stmt = $conn->prepare("INSERT INTO tasks (task, user_id) VALUES (?, ?)");
      $stmt->execute([$task, $_SESSION['user']['id']]);
      header('Location: index.php');
      exit();
    }
  } elseif (isset($_POST['completed'])) {
    $id = filter_input(INPUT_POST, 'completed');
    $completed = filter_input(INPUT_POST, 'completed_value');
    $stmt = $conn->prepare("UPDATE tasks SET completed = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$completed, $id, $_SESSION['user']['id']]);
    exit();
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Todo App</title>
  <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
  <div class="container">
    <h1>Welcome, <?= $_SESSION['user']['username'] ?></h1>
    <form method="post">
      <label for="task">New task:</label>
      <input type="text" name="task" id="task" required>
      <button type="submit">Add</button>
    </form>
    <h2>Tasks</h2>
    <table>
      <thead>
        <tr>
          <th>Task</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($tasks as $task): ?>
          <tr>
            <td><?= $task['task'] ?></td>
            <td>
              <form method="post">
                <input type="hidden" name="completed" value="<?= $task['id'] ?>">
                <input type="checkbox" name="completed_value" value="1" <?= $task['completed'] ? 'checked' : '' ?>>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <p><a href="../view/logout.php">Logout</a></p>
  </div>
</body>
</html>
