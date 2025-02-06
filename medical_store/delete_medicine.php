<?php
// Include database connection file
include 'connection.php';

// Get med_id from URL
$med_id = $_GET['med_id'] ?? null;

// Delete medicine
if ($med_id) {
    $sql = "DELETE FROM medicines WHERE med_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $med_id);
    
    if ($stmt->execute()) {
        echo "Medicine deleted successfully.";
    } else {
        echo "Error deleting medicine: " . $conn->error;
    }
} else {
    echo "Invalid medicine ID.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Medicine</title>
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
            <h2 class="text-2xl font-bold mb-6">Delete Medicine</h2>
            <p>
                <?php
                // Display result message
                if ($med_id) {
                    if ($stmt->execute()) {
                        echo "Medicine deleted successfully.";
                    } else {
                        echo "Error deleting medicine: " . $conn->error;
                    }
                } else {
                    echo "Invalid medicine ID.";
                }
                ?>
            </p>
            <a href="medicine.php" class="bg-teal-600 text-white py-2 px-4 rounded mt-4">Back to Medicine Management</a>
        </div>
    </div>
</body>
</html>
