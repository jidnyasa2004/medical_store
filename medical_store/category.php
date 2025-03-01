<?php
// Include the connection file
include 'connection.php';

// Initialize filter variable
$filter = $_GET['filter'] ?? '';

// Prepare the SQL query based on the filter
$sql = "SELECT * FROM medicines";
if ($filter) {
    $sql .= " WHERE type = ?";
}

// Prepare and execute the statement
$stmt = $conn->prepare($sql);
if ($filter) {
    $stmt->bind_param('s', $filter);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicine Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2d8c8c, #73a1a1, #c3dfd9);
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            background: #ffffff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .filter-dropdown {
            background: #2d8c8c;
            color: #ffffff;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
            width: auto;
        }
        .filter-dropdown select {
            appearance: none;
            background: transparent;
            border: none;
            color: #ffffff;
            padding: 0.5rem 0.75rem;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
            outline: none;
        }
        .filter-dropdown select option {
            color: #333; /* Change text color of dropdown items */
        }
        .filter-dropdown::after {
            content: '\25BC'; /* Down arrow */
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            pointer-events: none;
        }
        .product-card {
            background: #ffffff;
            padding: 1rem;
            border: 1px solid #ccc;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            height: 100%;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .product-card img {
            max-width: 100%;
            height: auto;
            margin-bottom: 1rem;
            border-radius: 10px;
            object-fit: cover;
        }
        .back-to-home {
            background: #ff6f61;
            color: #ffffff;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            margin-top: 1rem;
            display: inline-block;
            text-decoration: none;
            font-size: 1rem;
        }
        .back-to-home:hover {
            background: #e05a4f;
        }
    </style>
</head>
<body>
    <div class="container mt-10">
        <h1 class="text-2xl font-bold mb-6 text-teal-700">Medicine Categories</h1>
        <form method="GET" class="mb-6">
            <div class="filter-dropdown">
                <select name="filter" onchange="this.form.submit()">
                    <option value="">Select Category</option>
                    <option value="tablet" <?php if ($filter == 'tablet') echo 'selected'; ?>>Tablet</option>
                    <option value="syrup" <?php if ($filter == 'syrup') echo 'selected'; ?>>Syrup</option>
                    <option value="cream" <?php if ($filter == 'cream') echo 'selected'; ?>>Cream</option>
                    <option value="drops" <?php if ($filter == 'drops') echo 'selected'; ?>>Drops</option>
                </select>
            </div>
        </form>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product-card'>";
                    if (!empty($row['image_path'])) {
                        echo "<img src='" . htmlspecialchars($row['image_path']) . "' alt='" . htmlspecialchars($row['name']) . "'>";
                    }
                    echo "<h2 class='text-xl font-bold mb-2'>" . htmlspecialchars($row['name']) . "</h2>";
                    echo "<p class='text-gray-700 mb-2'>" . htmlspecialchars($row['description']) . "</p>";
                    echo "<p class='text-teal-700 font-bold'>₹" . htmlspecialchars($row['price']) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No medicines available</p>";
            }
            $stmt->close();
            ?>
        </div>
        <a href="homenew.php" class="back-to-home">Back to Home</a>
    </div>
</body>
</html>
