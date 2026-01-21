<?php
include 'db_connect.php';

$name = trim($_POST['name'] ?? '');
$reg = trim($_POST['reg'] ?? '');
$mobile = trim($_POST['mobile'] ?? '');
$dept = trim($_POST['dept'] ?? '');
$year = trim($_POST['year'] ?? '');
$pass = trim($_POST['pass'] ?? '');
$confirmPass = trim($_POST['confirmPass'] ?? '');

if (empty($name) || empty($reg) || empty($mobile) || empty($dept) || empty($year) || empty($pass) || empty($confirmPass)) {
    echo "<script>alert('⚠️ All fields are required'); window.history.back();</script>";
    exit();
}

if ($pass !== $confirmPass) {
    echo "<script>alert('❌ Passwords do not match'); window.history.back();</script>";
    exit();
}

// Create table if not exists
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  reg VARCHAR(50) UNIQUE,
  mobile VARCHAR(15),
  dept VARCHAR(50),
  year VARCHAR(10),
  password VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$check = $conn->prepare("SELECT * FROM students WHERE reg = ?");
$check->bind_param("s", $reg);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('⚠️ Register number already exists. Please login.'); window.location.href='login.html';</script>";
    exit();
}

$hashed = password_hash($pass, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO students (name, reg, mobile, dept, year, password) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $name, $reg, $mobile, $dept, $year, $hashed);

if ($stmt->execute()) {
    echo "<script>alert('✅ Signup successful! You can now login.'); window.location.href='login.html';</script>";
} else {
    echo "<script>alert('❌ Database error: " . mysqli_error($conn) . "'); window.history.back();</script>";
}
?>
