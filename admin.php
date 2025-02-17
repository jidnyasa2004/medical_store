<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
    <?php
    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "webdb");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch data for overview cards
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM medicines");
    $stmt->execute();
    $stmt->bind_result($totalMedicines);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("SELECT SUM(quantity) as stock FROM medicines");
    $stmt->execute();
    $stmt->bind_result($totalStock);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("SELECT COUNT(*) as totalOrders FROM orders");
    $stmt->execute();
    $stmt->bind_result($totalOrders);
    $stmt->fetch();
    $stmt->close();

    // Fetch data for tables
    $medicines = $conn->query("SELECT * FROM medicines LIMIT 10");
    $orders = $conn->query("SELECT order_id, customer_name, order_date, total_amount, no_of_items FROM orders LIMIT 10");
    ?>
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
            <div class="flex justify-between items-center">
                <h2 class="text-3xl font-bold">Dashboard</h2>
                <a href="logout1.php" class="bg-red-600 text-white py-2 px-4 rounded">Logout</a>
            </div>

            <!-- Overview Cards -->
            <div class="grid grid-cols-4 gap-6 mt-8">
                <div class="custom-card p-4">
                    <h3 class="text-xl font-bold">Total Medicines</h3>
                    <p class="text-2xl"><?= htmlspecialchars($totalMedicines) ?></p>
                </div>
                <div class="custom-card p-4">
                    <h3 class="text-xl font-bold">Stock</h3>
                    <p class="text-2xl"><?= htmlspecialchars($totalStock) ?></p>
                </div>
                <div class="custom-card p-4">
                    <h3 class="text-xl font-bold">Total Orders</h3>
                    <p class="text-2xl"><?= htmlspecialchars($totalOrders) ?></p>
                </div>
            </div>

            <!-- Section Tables -->
            <div class="mt-8">
                <div class="custom-card p-4 mb-6">
                    <h3 class="text-xl font-bold mb-4">Medicines</h3>
                    <div class="flex justify-start items-start">
                        <table class="min-w-full">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="py-2 px-4">Medicine</th>
                                    <th class="py-2 px-4">Quantity</th>
                                    <th class="py-2 px-4">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = $medicines->fetch_assoc()): ?>
                                    <tr>
                                        <td class="py-2 px-4"><?= htmlspecialchars($row['name']) ?></td>
                                        <td class="py-2 px-4"><?= htmlspecialchars($row['quantity']) ?></td>
                                        <td class="py-2 px-4">₹<?= htmlspecialchars($row['price']) ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="custom-card p-4 mb-6">
                    <h3 class="text-xl font-bold mb-4">Orders</h3>
                    <div class="flex justify-start items-start">
                        <table class="min-w-full">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="py-2 px-4">Order ID</th>
                                    <th class="py-2 px-4">Customer Name</th>
                                    <th class="py-2 px-4">Order Date</th>
                                    <th class="py-2 px-4">Total Amount</th>
                                    <th class="py-2 px-4">No. of Items</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($order = $orders->fetch_assoc()): ?>
                                    <tr>
                                        <td class="py-2 px-4"><?= htmlspecialchars($order['order_id']) ?></td>
                                        <td class="py-2 px-4"><?= htmlspecialchars($order['customer_name']) ?></td>
                                        <td class="py-2 px-4"><?= htmlspecialchars($order['order_date']) ?></td>
                                        <td class="py-2 px-4">₹<?= htmlspecialchars($order['total_amount']) ?></td>
                                        <td class="py-2 px-4"><?= htmlspecialchars($order['no_of_items']) ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    // Close connection
    $conn->close();
    ?>
</body>
</html>
