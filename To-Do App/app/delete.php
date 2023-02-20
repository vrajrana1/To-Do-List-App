<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: ../view/login.php');
  exit();
}

require('../Database/db.php');

$id = filter_input(INPUT_GET, 'id');
if ($id) {
  $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
  $stmt->execute([$id, $_SESSION['user']['id']]);
}

header('Location: index.php');
exit();
?>
