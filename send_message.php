
<?php
include 'db_connect.php';
$item_id = intval($_POST['item_id'] ?? 0);
$user = mysqli_real_escape_string($conn, $_POST['user'] ?? 'Guest');
$message = mysqli_real_escape_string($conn, $_POST['message'] ?? '');
if ($item_id && $message) {
  mysqli_query($conn, "INSERT INTO messages (item_id, sender, message) VALUES ('$item_id', '$user', '$message')");
  echo 'ok';
} else {
  echo 'error';
}
?>