
<?php
include 'db_connect.php';

$item = mysqli_real_escape_string($conn, $_POST['item'] ?? '');
$desc = mysqli_real_escape_string($conn, $_POST['desc'] ?? '');
$status = mysqli_real_escape_string($conn, $_POST['status'] ?? '');
$contact = mysqli_real_escape_string($conn, $_POST['contact'] ?? '');

$imagePath = '';
$ai_category = null;

if (!empty($_FILES['picture']['name'])) {
  $targetDir = "uploads/";
  if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
  $fileName = basename($_FILES['picture']['name']);
  $targetFile = $targetDir . time() . "_" . preg_replace('/[^A-Za-z0-9_.-]/', '_', $fileName);
  if (move_uploaded_file($_FILES['picture']['tmp_name'], $targetFile)) {
    $imagePath = $targetFile;

    // send to local AI service
    $ai_url = 'http://127.0.0.1:5000/predict';
    $curl = curl_init();
    $cfile = curl_file_create($targetFile);
    curl_setopt_array($curl, array(
      CURLOPT_URL => $ai_url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_POST => true,
      CURLOPT_POSTFIELDS => array('file' => $cfile),
      CURLOPT_TIMEOUT => 10
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($response && !$err) {
      $j = json_decode($response, true);
      if (isset($j['category'])) {
        $ai_category = mysqli_real_escape_string($conn, $j['category']);
      }
    }
  }
}

$query = "INSERT INTO items (item_name, description, status, contact, image, ai_category) VALUES ('$item', '$desc', '$status', '$contact', '$imagePath', '" . ($ai_category ? $ai_category : '') . "')";
if (mysqli_query($conn, $query)) {
  echo "success";
} else {
  echo "Database error: " . mysqli_error($conn);
}
?>