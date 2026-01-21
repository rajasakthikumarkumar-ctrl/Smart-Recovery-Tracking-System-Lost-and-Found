
<?php
include 'db_connect.php';
header('Content-Type: application/json; charset=utf-8');
$query = "SELECT id, item_name, description, status, contact, image, ai_category, DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s') AS created_at FROM items ORDER BY id DESC";
$result = mysqli_query($conn, $query);
$items = [];
while ($row = mysqli_fetch_assoc($result)) {
  $items[] = $row;
}
echo json_encode($items);
?>