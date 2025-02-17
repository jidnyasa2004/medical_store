<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Feedback Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2d8c8c, #73a1a1, #c3dfd9);
            font-family: 'Arial', sans-serif;
            position: relative;
            overflow: hidden;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            background: #ffffff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #2d8c8c; /* Teal */
            color: #ffffff; /* White text */
        }

        tr:hover {
            background: #f1f1f1;
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
<body>
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
            <div class="container">
                <h1 class="text-2xl font-bold mb-4">Feedback List</h1>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Name</th>
                            <th class="py-2 px-4 border-b">Date</th>
                            <th class="py-2 px-4 border-b">Feedback</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Database connection
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "webdb";

                        // Create connection
                        $conn = new mysqli($servername, $username, $password, $dbname);

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Fetch feedback data from the database
                        $sql = "SELECT name, date, feedback FROM feedback";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($row['name']) . "</td>";
                                echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($row['date']) . "</td>";
                                echo "<td class='py-2 px-4 border-b'>" . htmlspecialchars($row['feedback']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' class='py-2 px-4 border-b'>No feedback available</td></tr>";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
