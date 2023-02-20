<?php
session_start();
if (isset($_SESSION['user'])) {
  header('Location: ../app/index.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = filter_input(INPUT_POST, 'username');
  $password = filter_input(INPUT_POST, 'password');
  $confirmPassword = filter_input(INPUT_POST, 'confirm_password');

  $errors = array();
  if (empty($username)) {
    $errors[] = "Please enter a username.";
  }
  if (empty($password)) {
    $errors[] = "Please enter a password.";
  }
  if (empty($confirmPassword)) {
    $errors[] = "Please confirm your password.";
  }
  if ($password !== $confirmPassword) {
    $errors[] = "Passwords do not match.";
  }

  if (empty($errors)) {
    require('../Database/db.php');
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $hashedPassword]);
    $_SESSION['user'] = ['id' => $conn->lastInsertId(), 'username' => $username];
    header('Location: ../app/index.php');
    exit();
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
  <div class="container">
    <h1>Register</h1>
    <?php if (isset($errors) && !empty($errors)): ?>
      <div class="error">
        <?php foreach ($errors as $error): ?>
          <p><?= $error ?></p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <form method="post">
      <label for="username">Username:</label>
      <input type="text" name="username" id="username" required>
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" required>
      <label for="confirm_password">Confirm Password:</label>
      <input type="password" name="confirm_password" id="confirm_password" required>
      <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
  </div>
</body>
</html>
