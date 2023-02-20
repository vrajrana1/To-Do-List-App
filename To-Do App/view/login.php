<?php
session_start();
if (isset($_SESSION['user'])) {
  header('Location: ../app/index.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (empty($_POST['username']) || empty($_POST['password'])) {
    $error = "Please enter your username and password.";
  } else {
    require('../Database/db.php');
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if (!$user) {
      $error = "Incorrect username or password.";
    } else {
      if (password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        header('Location: ../app/index.php');
        exit();
      } else {
        $error = "Incorrect username or password.";
      }
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
  <div class="container">
    <h1>Login</h1>
    <?php if (isset($error)): ?>
      <div class="error"><?= $error ?></div>
    <?php endif; ?>
    <form method="post">
      <label for="username">Username:</label>
      <input type="text" name="username" id="username" required>
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" required>
      <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register</a></p>
  </div>
</body>
</html>
