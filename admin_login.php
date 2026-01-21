
<?php
include 'db_connect.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user = $_POST['user'] ?? '';
  $pass = $_POST['pass'] ?? '';
  // Simple static check; change to DB-based admin if needed
  if ($user === 'admin' && $pass === 'admin123') {
    $_SESSION['admin'] = true;
    header('Location: admin_dashboard.php');
    exit();
  } else {
    echo "<script>alert('Invalid admin credentials'); window.history.back();</script>";
  }
}
?>