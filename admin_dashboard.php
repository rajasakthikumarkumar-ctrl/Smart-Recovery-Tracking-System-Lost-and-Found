<?php
include 'db_connect.php';
session_start();

// Redirect if not logged in
if (!isset($_SESSION['admin'])) {
  header('Location: admin_login.html');
  exit();
}

// Fetch all items
$result = mysqli_query($conn, 'SELECT * FROM items ORDER BY created_at DESC');

// Handle logout
if (isset($_GET['logout'])) {
  session_destroy();
  header('Location: admin_login.html');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | Lost & Found</title>

  <style>
    body {
      font-family: "Poppins", sans-serif;
      background: linear-gradient(270deg, #74ebd5, #ACB6E5, #89f7fe, #66a6ff);
      background-size: 400% 400%;
      animation: gradientBG 15s ease infinite;
      margin: 0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    header {
      width: 100%;
      background: #1e3c72;
      color: #fff;
      text-align: center;
      padding: 18px 0;
      font-size: 1.6rem;
      font-weight: 700;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
      position: relative;
    }

    /* Back button (left) */
    .back-btn {
      position: absolute;
      top: 50%;
      left: 15px;
      transform: translateY(-50%);
      background: #fff;
      border: none;
      padding: 6px 12px;
      border-radius: 6px;
      font-weight: 600;
      font-size: 13px;
      cursor: pointer;
      color: #1e3c72;
      text-decoration: none;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
      transition: 0.3s ease;
    }

    .back-btn:hover {
      background: #eef2ff;
      transform: translateY(-50%) scale(1.05);
    }

    /* Right-side text buttons */
    .top-link {
      position: relative;
      top: -2px;
      margin-right: 10px;
      cursor: pointer;
      color: #fff;
      font-size: 14px;
      font-weight: 500;
      text-decoration: none;
      transition: 0.3s ease;
    }

    .top-link:hover {
      text-decoration: underline;
      opacity: 0.85;
    }

    /* Logout Button */
    .logout-btn {
      background: #f44336;
      color: white;
      border: none;
      padding: 6px 12px;
      border-radius: 6px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s ease;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
      text-decoration: none;
    }

    .logout-btn:hover {
      background: #d32f2f;
      transform: scale(1.05);
    }

    /* Container for right side buttons */
    .right-buttons {
      position: absolute;
      top: 50%;
      right: 15px;
      transform: translateY(-50%);
      display: flex;
      align-items: center;
      gap: 12px;
    }

    main {
      width: 95%;
      max-width: 1000px;
      background: #fff;
      margin: 30px auto;
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
    }

    h2 {
      color: #1e3c72;
      text-align: center;
      margin-bottom: 20px;
      font-weight: 700;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
      font-size: 15px;
    }

    th, td {
      padding: 12px;
      border-bottom: 1px solid #ddd;
    }

    th {
      background: #1e3c72;
      color: #fff;
    }

    tr:nth-child(even) {
      background: #f9f9f9;
    }

    tr:hover {
      background: #eef2ff;
    }

    .delete-btn {
      background: #f44336;
      color: #fff;
      padding: 6px 12px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 600;
      transition: 0.3s ease;
    }

    .delete-btn:hover {
      background: #d32f2f;
    }

    footer {
      background: #1e3c72;
      color: #fff;
      text-align: center;
      padding: 12px 0;
      font-size: 14px;
      margin-top: auto;
      width: 100%;
      border-radius: 20px 20px 0 0;
      box-shadow: 0 -4px 12px rgba(0,0,0,0.25);
    }
  </style>
</head>

<body>

  <header>
    <a href="login.html" class="back-btn">← Back</a>

    Admin Dashboard | Lost & Found

    <!-- Right side buttons -->
    <div class="right-buttons">
      <a class="top-link" href="home.html">Home</a>
      <a class="top-link" href="feed.html">Feed</a>
      <a href="?logout=true" class="logout-btn">Logout</a>
    </div>
  </header>

  <main>
    <h2>Item Management</h2>

    <table>
      <tr>
        <th>ID</th>
        <th>Item Name</th>
        <th>Status</th>
        <th>AI Category</th>
        <th>Contact</th>
        <th>Action</th>
      </tr>

      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['item_name']) ?></td>
        <td><?= htmlspecialchars($row['status']) ?></td>
        <td><?= htmlspecialchars($row['ai_category']) ?></td>
        <td><?= htmlspecialchars($row['contact']) ?></td>
        <td>
          <a href="delete_item.php?id=<?= $row['id'] ?>" 
             class="delete-btn"
             onclick="return confirm('Are you sure you want to delete this item?')">
             Delete
          </a>
        </td>
      </tr>
      <?php } ?>

    </table>
  </main>

  <footer>© 2025 Lost & Found — Admin Panel</footer>

</body>
</html>
