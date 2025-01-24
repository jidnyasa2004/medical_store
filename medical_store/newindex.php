<?php
// Include connection file
include 'connection.php';

// Start session
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $usrname = $_POST['usrname'];
  $passwordd = $_POST['passwordd'];
  $user_type = $_POST['user_type'];

  // Query the database to check credentials
  $sql = "SELECT * FROM credential WHERE username='$usrname' AND password='$passwordd' AND user_type='$user_type'";
  $result = $conn->query($sql);

  if (!$result) { 
    die("Error executing query: " . $conn->error);
  }

  if ($result->num_rows > 0) {
    // Login successful 
    $_SESSION['usrname'] = $usrname;
    $_SESSION['user_type'] = $user_type;
    
    if ($user_type == 'admin') {
        $success_message = "Admin login successful! Redirecting...";
        echo '<script type="text/javascript"> 
          setTimeout(function() { 
            window.location.href = "admin_dashboard.php"; 
          }, 2000); 
        </script>';
    } else {
        $success_message = "User login successful! Redirecting...";
        echo '<script type="text/javascript"> 
          setTimeout(function() { 
            window.location.href = "homenew.php"; 
          }, 2000); 
        </script>';
    }
  } else {
    // Login failed
    $error_message = "Invalid username or password.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #2d8c8c, #73a1a1, #c3dfd9);
      position: relative;
      overflow: hidden;
    }

    .floating-placeholder {
      position: relative;
    }

    .floating-placeholder input, .floating-placeholder select {
      border: 1px solid #73a1a1;
      padding: 1rem 0.5rem 0.5rem 0.5rem;
      border-radius: 0.25rem;
      background: #e8f6f6;
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

    .floating-placeholder input:focus+label,
    .floating-placeholder input:not(:placeholder-shown)+label,
    .floating-placeholder select:focus+label,
    .floating-placeholder select:not(:placeholder-shown)+label {
      top: -0.75rem;
      left: 0.5rem;
      font-size: 1rem;
      color: #1e3c3c;
      background: #e8f6f6;
    }

    .password-container {
      position: relative;
    }

    .password-container .toggle-password {
      position: absolute;
      top: 50%;
      right: 0.5rem;
      transform: translateY(-50%);
      cursor: pointer;
      color: #2d8c8c;
    }
    
    .login-btn {
      width: 100%;
      padding: 0.5rem 0;
      background-color: #2d8c8c;
      color: white;
      border: none;
      border-radius: 0.25rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .login-btn:hover {
      background-color: #1e3c3c;
    }
  </style>
</head>

<body class="flex justify-center items-center min-h-screen">
  <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold mb-6 text-teal-700 text-center">Sign In</h1>
    <form method="POST" action="">
      <!-- User type selection -->
      <div class="mb-4 floating-placeholder">
        <select name="user_type" id="user_type" class="w-full px-4 py-2 border border-teal-600 rounded-lg bg-teal-50 text-teal-900 focus:outline-none focus:ring-2 focus:ring-teal-600" required>
          <option value="" disabled selected hidden></option>
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>
        <label for="user_type">User Type</label>
      </div>
      <!-- Username block -->
      <div class="mb-4 floating-placeholder">
        <input type="text" name="usrname" id="usrname" placeholder=" "
          class="w-full px-4 py-2 border border-teal-600 rounded-lg bg-teal-50 text-teal-900 focus:outline-none focus:ring-2 focus:ring-teal-600" required>
        <label for="usrname">Username</label>
      </div>
      <!-- Password block -->
      <div class="mb-6 floating-placeholder password-container">
        <input type="password" name="passwordd" id="passwordd" placeholder=" "
          class="w-full px-4 py-2 border border-teal-600 rounded-lg bg-teal-50 text-teal-900 focus:outline-none focus:ring-2 focus:ring-teal-600" required>
        <label for="passwordd">Password</label>
        <span class="toggle-password" onclick="togglePassword()">👁️</span>
      </div>
      <button type="submit" class="login-btn">Login</button>
      <div class="flex justify-between items-center mt-4 text-teal-500">
        <a href="forget_password.php" class="hover:underline">Forgot Password?</a>
        <a href="register.php" class="hover:underline">Sign Up</a>
      </div>
    </form>
    <?php
    if (isset($success_message)) {
      echo '<p class="text-green-500 text-center mt-4">' . $success_message . '</p>';
    }
    if (isset($error_message)) {
      echo '<p class="text-red-500 text-center mt-4">' . $error_message . '</p>';
    }
    ?>
  </div>
  <script>
    function togglePassword() {
      const passwordField = document.getElementById('passwordd');
      const passwordToggle = document.querySelector('.toggle-password');
      if (passwordField.type === 'password') {
        passwordField.type = 'text';
        passwordToggle.textContent = '🙈';
      } else {
        passwordField.type = 'password';
        passwordToggle.textContent = '👁️';
      }
    }
  </script>
</body>

</html>
