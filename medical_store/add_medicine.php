<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Medicine</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .custom-bg {
            background: linear-gradient(135deg, #2d8c8c, #73a1a1, #c3dfd9);
        }
    </style>
</head>
<body class="custom-bg">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6">Add Medicine</h1>
        <form action="add_medicine.php" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Medicine Name</label>
                <input type="text" id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description</label>
                <textarea id="description" name="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="type">Type</label>
                <input type="text" id="type" name="type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="exp_date">Expiration Date</label>
                <input type="date" id="exp_date" name="exp_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="mfg_date">Manufacturing Date</label>
                <input type="date" id="mfg_date" name="mfg_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="price">Price</label>
                <input type="number" id="price" name="price" step="0.01" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Medicine Image</label>
                <input type="file" id="image" name="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Add Medicine</button>
            </div>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Connect to the database
            $conn = new mysqli("localhost", "root", "", "webdb");

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Get form data
            $name = $_POST['name'];
            $description = $_POST['description'];
            $type = $_POST['type'];
            $quantity = $_POST['quantity'];
            $exp_date = $_POST['exp_date'];
            $mfg_date = $_POST['mfg_date'];
            $price = $_POST['price'];

            // Handle image upload
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_path = $target_file;
            } else {
                echo "<p class='text-red-500 mt-4'>Sorry, there was an error uploading your file.</p>";
                $image_path = '';
            }

            // Insert data into database with image path
            $sql = "INSERT INTO medicines (name, description, type, quantity, exp_date, mfg_date, price, image_path) VALUES ('$name', '$description', '$type', $quantity, '$exp_date', '$mfg_date', $price, '$image_path')";

            if ($conn->query($sql) === TRUE) {
                echo "<p class='text-green-500 mt-4'>New record created successfully</p>";
            } else {
                echo "<p class='text-red-500 mt-4'>Error: " . $sql . "<br>" . $conn->error . "</p>";
            }

            // Close connection
            $conn->close();
        }
        ?>
    </div>
</body>
</html>
