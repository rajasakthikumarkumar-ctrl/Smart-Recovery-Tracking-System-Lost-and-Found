
<?php
include 'db_connect.php';
$id = intval($_GET['id'] ?? 0);
if ($id) {
  $res = mysqli_query($conn, "SELECT image FROM items WHERE id=$id");
  if ($r = mysqli_fetch_assoc($res)) {
    if (!empty($r['image']) && file_exists($r['image'])) unlink($r['image']);
  }
  mysqli_query($conn, "DELETE FROM items WHERE id=$id");
}
header('Location: admin_dashboard.php');
?>