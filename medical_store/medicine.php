<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicine Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
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

    // Fetch data for medicines
    $medicines = $conn->query("SELECT * FROM medicines");
    ?>
    <div class="flex">
        <!-- Left Sidebar -->
        <div class="w-1/6 custom-sidebar text-white h-screen">
            <div class="p-4">
                <h1 class="text-2xl font-bold">MEDICAL STORE</h1>
                <ul class="mt-8">
                    <li class="mt-4"><a href="medicine.php">Medicine</a></li>
                    <li class="mt-4"><a href="stock.php">Stock</a></li>
                    <li class="mt-4"><a href="order.php">Order</a></li>
                    <li class="mt-4"><a href="payment.php">Payment</a></li>
                    <li class="mt-4"><a href="feedback.php">Feedback</a></li>
                </ul>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex-grow container mx-auto p-4">
            <!-- Top Bar -->
            <div class="flex justify-center items-center mb-6">
                <h1 class="text-2xl font-bold mr-auto">Medicine</h1>
                <div class="w-1/3">
                    <input type="text" placeholder="Search..." class="w-full px-4 py-2 rounded border border-gray-300">
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <?php while($row = $medicines->fetch_assoc()): ?>
                    <div class="custom-card p-4 rounded shadow">
                        <h2 class="text-xl font-semibold"><?= htmlspecialchars($row['name']) ?></h2>
                        <p><?= htmlspecialchars($row['description']) ?></p>
                        <div class="mt-4 flex justify-between">
                            <a href="update_medicine.php?med_id=<?= htmlspecialchars($row['med_id']) ?>" class="bg-yellow-500 text-white px-4 py-2 rounded">Update</a>
                            <a href="delete_medicine.php?med_id=<?= htmlspecialchars($row['med_id']) ?>" class="bg-red-500 text-white px-4 py-2 rounded">Delete</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

       
    
    <?php
    // Close connection
    $conn->close();
    ?>
</body>
</html>
