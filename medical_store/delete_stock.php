<?php
// Include database connection file
include 'connection.php';

// Get stock_id from URL
$stock_id = $_GET['stock_id'] ?? null;

// Delete stock item
if ($stock_id) {
    $sql = "DELETE FROM stock WHERE stock_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $stock_id);
    
    if ($stmt->execute()) {
        echo "Stock item deleted successfully.";
    } else {
        echo "Error deleting stock item: " . $conn->error;
    }
} else {
    echo "Invalid stock ID.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Stock</title>
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
            <h2 class="text-2xl font-bold mb-6">Delete Stock</h2>
            <p>
                <?php
                // Display result message
                if ($stock_id) {
                    if ($stmt->execute()) {
                        echo "Stock item deleted successfully.";
                    } else {
                        echo "Error deleting stock item: " . $conn->error;
                    }
                } else {
                    echo "Invalid stock ID.";
                }
                ?>
            </p>
            <a href="stock.php" class="bg-teal-600 text-white py-2 px-4 rounded mt-4">Back to Stock Management</a>
        </div>
    </div>
</body>
</html>
