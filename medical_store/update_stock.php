<?php
// Include database connection file
include 'connection.php';

// Get stock_id from URL
$stock_id = $_GET['stock_id'] ?? null;

// Initialize variables
$name = $description = $type = $quantity = '';

// Fetch current stock details
if ($stock_id) {
    $sql = "SELECT name, description, type, quantity FROM stock WHERE stock_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $stock_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $description = $row['description'];
        $type = $row['type'];
        $quantity = $row['quantity'];
    } else {
        echo "Stock item not found.";
        exit;
    }
}

// Update stock details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $type = $_POST['type'];
    $quantity = $_POST['quantity'];
    
    $sql = "UPDATE stock SET name = ?, description = ?, type = ?, quantity = ? WHERE stock_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssii', $name, $description, $type, $quantity, $stock_id);
    
    if ($stmt->execute()) {
        echo "Stock updated successfully.";
    } else {
        echo "Error updating stock: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Stock</title>
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
            <h2 class="text-2xl font-bold mb-6">Update Stock</h2>
            <form method="POST">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Name:</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" class="w-full border rounded py-2 px-3">
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700">Description:</label>
                    <input type="text" id="description" name="description" value="<?= htmlspecialchars($description) ?>" class="w-full border rounded py-2 px-3">
                </div>
                <div class="mb-4">
                    <label for="type" class="block text-gray-700">Type:</label>
                    <input type="text" id="type" name="type" value="<?= htmlspecialchars($type) ?>" class="w-full border rounded py-2 px-3">
                </div>
                <div class="mb-4">
                    <label for="quantity" class="block text-gray-700">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" value="<?= htmlspecialchars($quantity) ?>" class="w-full border rounded py-2 px-3">
                </div>
                <button type="submit" class="bg-teal-600 text-white py-2 px-4 rounded">Update</button>
            </form>
        </div>
    </div>
</body>
</html>
