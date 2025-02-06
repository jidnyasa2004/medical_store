<?php
// Include database connection file
include 'connection.php';

// Fetch stock data from the database
$sql = "SELECT stock.stock_id, medicines.name, medicines.description, stock.type, stock.quantity
        FROM stock
        JOIN medicines ON stock.med_id = medicines.med_id";
$result = $conn->query($sql);

// Error checking for the query
if (!$result) {
    die("Query failed: " . $conn->error);
}

// Process form submission to add stock
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $med_id = $_POST['med_id'];
    $type = $_POST['type'];
    $quantity = $_POST['quantity'];

    $sql_insert = "INSERT INTO stock (med_id, type, quantity) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param('isi', $med_id, $type, $quantity);

    if ($stmt->execute()) {
        echo "Stock added successfully.";
        // Refresh the page to show the new stock
        header("Location: stock.php");
        exit();
    } else {
        echo "Error adding stock: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Management</title>
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
        .table-header {
            background-color: #2d8c8c; /* Teal */
            color: white; /* White text */
        }
    </style>
</head>
<body class="custom-bg">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-1/6 custom-sidebar text-white h-screen">
            <div class="p-4">
                <h1 class="text-2xl font-bold">LOGO</h1>
                <ul class="mt-8">
                    <li class="mt-4"><a href="medicine.php">Medicine</a></li>
                    <li class="mt-4"><a href="add_medicine.php">Add Medicine</a></li>
                    <li class="mt-4"><a href="stock.php">Stock</a></li>
                    <li class="mt-4"><a href="order.php">Order</a></li>
                    <li class="mt-4">Payment</li>
                    <li class="mt-4">Feedback</li>
                </ul>
            </div>
        </div>

        <!-- Main content -->
        <div class="w-5/6 p-6">
            <div class="flex justify-between items-center">
                <h2 class="text-3xl font-bold">Stock Management</h2>
                <a href="logout1.php" class="bg-red-600 text-white py-2 px-4 rounded">Logout</a>
            </div>

            <!-- Add Stock Form -->
            <div class="mt-8">
                <div class="custom-card p-4">
                    <h3 class="text-xl font-bold mb-4">Add Stock</h3>
                    <form method="POST" class="flex flex-col space-y-4">
                        <div>
                            <label for="med_id" class="block text-gray-700">Medicine ID:</label>
                            <input type="number" id="med_id" name="med_id" required class="w-full border rounded py-2 px-3">
                        </div>
                        <div>
                            <label for="type" class="block text-gray-700">Type:</label>
                            <input type="text" id="type" name="type" required class="w-full border rounded py-2 px-3">
                        </div>
                        <div>
                            <label for="quantity" class="block text-gray-700">Quantity:</label>
                            <input type="number" id="quantity" name="quantity" required class="w-full border rounded py-2 px-3">
                        </div>
                        <button type="submit" class="bg-teal-600 text-white py-2 px-4 rounded">Add Stock</button>
                    </form>
                </div>
            </div>

            <!-- Stock Table -->
            <div class="mt-8">
                <div class="custom-card p-4">
                    <h3 class="text-xl font-bold mb-4">Stock Levels</h3>
                    <div class="flex justify-start items-start">
                        <table class="min-w-full bg-white shadow-md rounded-lg">
                            <thead class="table-header">
                                <tr>
                                    <th class="py-3 px-5">Stock ID</th>
                                    <th class="py-3 px-5">Name</th>
                                    <th class="py-3 px-5">Description</th>
                                    <th class="py-3 px-5">Type</th>
                                    <th class="py-3 px-5">Quantity</th>
                                    <th class="py-3 px-5">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    // Output data of each row
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr class='border-b hover:bg-teal-50'>";
                                        echo "<td class='py-2 px-5'>" . htmlspecialchars($row["stock_id"]) . "</td>";
                                        echo "<td class='py-2 px-5'>" . htmlspecialchars($row["name"]) . "</td>";
                                        echo "<td class='py-2 px-5'>" . htmlspecialchars($row["description"]) . "</td>";
                                        echo "<td class='py-2 px-5'>" . htmlspecialchars($row["type"]) . "</td>";
                                        echo "<td class='py-2 px-5'>" . htmlspecialchars($row["quantity"]) . "</td>";
                                        echo "<td class='py-2 px-5'>";
                                        echo "<a href='update_stock.php?stock_id=" . htmlspecialchars($row["stock_id"]) . "' class='bg-yellow-500 text-white py-1 px-3 rounded'>Update</a> ";
                                        echo "<a href='delete_stock.php?stock_id=" . htmlspecialchars($row["stock_id"]) . "' class='bg-red-500 text-white py-1 px-3 rounded'>Delete</a>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='py-2 px-4 text-center'>No stock found</td></tr>";
                                }
                                ?>
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
