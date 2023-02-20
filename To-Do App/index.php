<?php
session_start();
if (isset($_SESSION['user'])) {
  header('Location: app/index.php');
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Todo App</title>
  <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
  <div class="container">
    <h1>Todo App</h1>
    <a href="view/login.php">Login</a> or <a href="view/register.php">Register</a> to get started.
  </div>
</body>
</html>