<?php
// Include database connection file
include 'connection.php';

// Initialize search variable
$search = $_GET['search'] ?? '';

// Prepare and execute the statement
$sql = "SELECT order_id, med_id, no_of_items, date_time FROM orders WHERE order_id LIKE ? OR med_id LIKE ?";
$stmt = $conn->prepare($sql);
$search_term = '%' . $search . '%';
$stmt->bind_param('ss', $search_term, $search_term);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2d8c8c, #73a1a1, #c3dfd9);
            position: relative;
            overflow: hidden;
        }
        .table-header {
            background-color: #2d8c8c; /* Teal */
            color: white; /* White text */
        }
    </style>
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-teal-700">Order Management</h1>

        <!-- Search Form -->
        <form method="GET" class="mb-4">
            <input type="text" name="search" placeholder="Search Orders" class="border rounded py-2 px-3" value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="bg-teal-600 text-white py-2 px-4 rounded">Search</button>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg">
                <thead class="table-header">
                    <tr>
                        <th class="py-3 px-5">Order ID</th>
                        <th class="py-3 px-5">Medicine ID</th>
                        <th class="py-3 px-5">Number of Items</th>
                        <th class="py-3 px-5">Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr class='border-b hover:bg-teal-50'>";
                            echo "<td class='py-2 px-5'>" . htmlspecialchars($row["order_id"]) . "</td>";
                            echo "<td class='py-2 px-5'>" . htmlspecialchars($row["med_id"]) . "</td>";
                            echo "<td class='py-2 px-5'>" . htmlspecialchars($row["no_of_items"]) . "</td>";
                            echo "<td class='py-2 px-5'>" . htmlspecialchars($row["date_time"]) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='py-2 px-4 text-center'>No orders found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
