<?php
// Include database connection file
include 'connection.php';

// Get med_id from URL
$med_id = $_GET['med_id'] ?? null;

// Initialize variables
$name = $description = '';

// Fetch current medicine details
if ($med_id) {
    $sql = "SELECT name, description FROM medicines WHERE med_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $med_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $description = $row['description'];
    } else {
        echo "Medicine not found.";
        exit;
    }
}

// Update medicine details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];

    $sql = "UPDATE medicines SET name = ?, description = ? WHERE med_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $name, $description, $med_id);

    if ($stmt->execute()) {
        echo "<script>alert('Medicine updated successfully!'); window.location.href='medicines_list.php';</script>";
    } else {
        echo "Error updating medicine: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Medicine</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2d8c8c, #73a1a1, #c3dfd9);
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #0077b6;
        }
        label {
            font-weight: bold;
            color: #2d8c8c;
        }
        input, textarea {
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 8px;
            margin-top: 5px;
        }
        button {
            background: #0077b6;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #005bb5;
        }
        .back-btn {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            color: #ffffff;
            background: #2d8c8c;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .back-btn:hover {
            background: #1f6b6b;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-2xl font-bold mb-6">Update Medicine</h2>
    <form method="POST">
        <div class="mb-4">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required>
        </div>
        <div class="mb-4">
            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?= htmlspecialchars($description) ?></textarea>
        </div>
        <button type="submit">Update</button>
        <a href="medicines_list.php" class="back-btn">Back</a>
    </form>
</div>

</body>
</html>
