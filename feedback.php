<?php
// Include connection file
include 'connection.php';

// Start session
session_start();

if (!isset($_SESSION['usrname'])) {
    header("Location: homenew.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-md mx-auto bg-white p-5 rounded shadow-md">
        <h1 class="text-2xl font-bold mb-4">Feedback</h1>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_SESSION['usrname'];
            $date = date("Y-m-d"); // Set current date
            $message = htmlspecialchars($_POST["message"]);

            // Database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "webdb";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Generate new fb_id
            $result = $conn->query("SELECT COUNT(*) AS count FROM feedback");
            $row = $result->fetch_assoc();
            $new_id = "FB" . str_pad($row["count"] + 1, 4, "0", STR_PAD_LEFT);

            // Insert feedback into the database
            $stmt = $conn->prepare("INSERT INTO feedback (fb_id, name, date, feedback) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $new_id, $name, $date, $message);

            if ($stmt->execute()) {
                echo "<p class='text-green-500'>Thank you for your feedback!</p>";
            } else {
                echo "<p class='text-red-500'>Error: " . $stmt->error . "</p>";
            }

            $stmt->close();
            $conn->close();
        }
        ?>
        <form method="POST" action="">
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name:</label>
                <input type="text" id="name" name="name" class="w-full p-2 border border-gray-300 rounded mt-1" value="<?php echo $_SESSION['usrname']; ?>" readonly>
            </div>
            <div class="mb-4">
                <label for="date" class="block text-gray-700">Date:</label>
                <input type="date" id="date" name="date" class="w-full p-2 border border-gray-300 rounded mt-1" value="<?php echo date('Y-m-d'); ?>" required readonly>
            </div>
            <div class="mb-4">
                <label for="message" class="block text-gray-700">Feedback:</label>
                <textarea id="message" name="message" class="w-full p-2 border border-gray-300 rounded mt-1" rows="5" required></textarea>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Submit</button>
        </form>
    </div>
</body>
</html>
