<?php
include 'db_connect.php';
session_start();

$reg = trim($_POST['reg'] ?? '');
$pass = trim($_POST['pass'] ?? '');

if (empty($reg) || empty($pass)) {
    // Missing fields → redirect back
    header("Location: login.html");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM students WHERE reg = ?");
$stmt->bind_param("s", $reg);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {

    $student = $result->fetch_assoc();

    if (password_verify($pass, $student['password'])) {

        // Store user session
        $_SESSION['user_id'] = $student['id'];
        $_SESSION['name'] = $student['name'];
        $_SESSION['reg'] = $student['reg'];
        $_SESSION['dept'] = $student['dept'];
        $_SESSION['year'] = $student['year'];

        // Redirect to home page (NO popup)
        header("Location: home.html");
        exit();
    }
}

// Invalid login → redirect back silently
header("Location: login.html");
exit();
?>
