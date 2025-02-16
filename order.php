<?php
// Include database connection file
include 'connection.php';

// Initialize search variable
$search = $_GET['search'] ?? '';

// Prepare and execute the statement
$sql = "SELECT order_id, med_id, no_of_items, date_time, total_amount FROM orders WHERE order_id LIKE ? OR med_id LIKE ?";
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
        .custom-bg {
            background: linear-gradient(135deg, #2d8c8c, #73a1a1, #c3dfd9);
        }
        .custom-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .custom-sidebar {
            background: #1e3c3c;
        }
        .custom-sidebar li {
            padding: 12px 16px;
            cursor: pointer;
        }
        .custom-sidebar li:hover {
            background: #334155;
        }
    </style>
</head>
<body class="custom-bg">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-1/6 custom-sidebar text-white h-screen">
            <div class="p-4">
                <h1 class="text-2xl font-bold">MEDICAL STORE</h1>
                <ul class="mt-8">
                <li class="mt-4"><a href="admin.php">DASHBOARD</a></li>
                    <li class="mt-4"><a href="medicine.php">Medicine</a></li>
                    <li class="mt-4"><a href="add_medicine.php">Add Medicine</a></li>
                    <li class="mt-4"><a href="stock.php">Stock</a></li>
                    <li class="mt-4"><a href="order.php">Order</a></li>
                    <li class="mt-4">Payment</li>
                    <li class="mt-4"><a href="view_feedback.php">Feedback</a></li>
                </ul>
            </div>
        </div>

        <!-- Main content -->
        <div class="w-5/6 p-6">
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
                                <th class="py-3 px-5">Total Amount</th>
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
                                    echo "<td class='py-2 px-5'>" . htmlspecialchars($row["total_amount"]) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='py-2 px-4 text-center'>No orders found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
