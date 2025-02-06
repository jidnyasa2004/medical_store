<?php
// Include connection file
include 'connection.php';

// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['usrname'])) {
    header("Location: home.php");
    exit();
}

// Fetch user profile information
$usrname = $_SESSION['usrname'];
$sql = "SELECT email, username FROM credential WHERE username='$usrname'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #2d8c8c, #73a1a1, #c3dfd9);
      display: flex;
    }

    .sidebar {
      width: 250px;
      background: #e8f6f6;
      color: #2d2d2d;
      padding: 20px;
      position: fixed;
      top: 0;
      right: 0;
      height: 100%;
      transform: translateX(100%);
      transition: transform 0.3s ease;
    }

    .sidebar.open {
      transform: translateX(0);
    }

    .main-content {
      flex-grow: 1;
      padding: 20px;
      color: #2d2d2d;
      transition: margin-right 0.3s ease;
    }

    .sidebar.open ~ .main-content {
      margin-right: 250px;
    }

    .floating-placeholder {
      position: relative;
    }

    .floating-placeholder input {
      border: 1px solid #73a1a1;
      padding: 1rem 0.5rem 0.5rem 0.5rem;
      border-radius: 0.25rem;
      background: transparent;
      color: #2d2d2d;
      width: 100%;
    }

    .floating-placeholder label {
      position: absolute;
      top: 1rem;
      left: 0.5rem;
      color: #2d8c8c;
      padding: 0 0.25rem;
      transition: all 0.2s ease;
      pointer-events: none;
    }

    .floating-placeholder input:focus + label,
    .floating-placeholder input:not(:placeholder-shown) + label {
      top: -0.75rem;
      left: 0.5rem;
      font-size: 1rem;
      color: #1e3c3c;
      background: #e8f6f6;
    }

    .sidebar a {
      display: block;
      padding: 10px 0;
      color: #2d8c8c;
      text-decoration: none;
      transition: color 0.2s;
    }

    .sidebar a:hover {
      color: #1e3c3c;
    }

    .profile-icon {
      position: fixed;
      top: 20px;
      right: 20px;
      cursor: pointer;
      color: #2d2d2d;
      font-size: 2rem;
    }
  </style>
</head>

<body>
  <div class="sidebar" id="sidebar">
    <h2 class="text-2xl font-bold mb-4">Profile</h2>
    <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
    <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
    <nav class="mt-4">
      <a href="update_profile.php">Update</a>
      <a href="view_list.php">View List</a>
      <a href="logout.php">Logout</a>
    </nav>
  </div>
  <div class="main-content" id="main-content">
    <span class="profile-icon" onclick="toggleSidebar()">👤</span>
    <h1 class="text-3xl font-bold">Welcome, <?php echo $user['username']; ?>!</h1>
    <p>This is your home page.</p>
  </div>

  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('open');
    }
  </script>
</body>

</html>
