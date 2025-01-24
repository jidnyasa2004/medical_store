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
        echo "Medicine updated successfully.";
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
        .custom-bg {
            background: linear-gradient(135deg, #2d8c8c, #73a1a1, #c3dfd9);
        }
        .custom-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="custom-bg">
    <div class="container mx-auto p-6">
        <div class="custom-card p-6">
            <h2 class="text-2xl font-bold mb-6">Update Medicine</h2>
            <form method="POST">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Name:</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" class="w-full border rounded py-2 px-3">
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700">Description:</label>
                    <textarea id="description" name="description" class="w-full border rounded py-2 px-3"><?= htmlspecialchars($description) ?></textarea>
                </div>
                <button type="submit" class="bg-teal-600 text-white py-2 px-4 rounded">Update</button>
            </form>
        </div>
    </div>
</body>
</html>
