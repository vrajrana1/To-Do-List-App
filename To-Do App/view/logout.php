<?php
session_start();
session_destroy();
header('Location: ../index.php');
//session must bre reuqire
exit();
?>
