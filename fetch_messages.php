
<?php
include 'db_connect.php';
$item_id = intval($_GET['item_id'] ?? 0);
$result = mysqli_query($conn, "SELECT sender, message, DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s') AS created_at FROM messages WHERE item_id=$item_id ORDER BY created_at ASC");
$messages = [];
while ($row = mysqli_fetch_assoc($result)) $messages[] = $row;
header('Content-Type: application/json; charset=utf-8');
echo json_encode($messages);
?>