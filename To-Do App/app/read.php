<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: ../view/login.php');
  exit();
}

require('../Database/db.php');
$stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ?");
$stmt->execute([$_SESSION['user']['id']]);
$tasks = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
  <title>My Tasks - Todo App</title>
  <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
  <div class="container">
    <h1>My Tasks</h1>
    <table>
      <thead>
        <tr>
          <th>Task</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($tasks as $task): ?>
          <tr>
            <td><?php echo $task['task']; ?></td>
            <td>
              <a href="edit.php?id=<?php echo $task['id']; ?>">Edit</a>
              <a href="delete.php?id=<?php echo $task['id']; ?>">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <p><a href="create.php">Create New Task</a></p>
    <p><a href="../view/logout.php">Logout</a></p>
  </div>
</body>
</html>
