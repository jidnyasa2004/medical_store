<?php
// Include connection file
include 'connection.php';

// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['usrname'])) {
    header("Location: homenew.php");
    exit();
}

// Fetch user profile information
$usrname = $_SESSION['usrname'];
$sql_user = "SELECT email, username FROM credential WHERE username='$usrname'";
$result_user = $conn->query($sql_user);
$user = $result_user->fetch_assoc();

// Fetch medicines from database
$search_query = isset($_GET['search']) ? $_GET['search'] : '';
if ($search_query) {
    $sql_medicines = "SELECT name, description, image_path, price FROM medicines WHERE name LIKE '%$search_query%'";
} else {
    $sql_medicines = "SELECT name, description, image_path, price FROM medicines";
}
$result_medicines = $conn->query($sql_medicines);
$medicines = [];
if ($result_medicines->num_rows > 0) {
    while ($row = $result_medicines->fetch_assoc()) {
        $medicines[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f4f7;
            font-family: 'Arial', sans-serif;
        }

        header {
            background: #0077b6;
            padding: 1rem;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .nav-links a {
            color: #ffffff;
            text-decoration: none;
            margin: 0 1rem;
            transition: color 0.2s;
        }

        .nav-links a:hover {
            color: #ffdd57;
        }

        .profile-icon {
            color: #ffffff;
            cursor: pointer;
            font-size: 1.5rem;
        }

        .profile-menu {
            display: none;
            position: absolute;
            top: 60px;
            right: 20px;
            background: #ffffff;
            padding: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .profile-menu a {
            display: block;
            color: #0077b6;
            text-decoration: none;
            padding: 0.5rem 0;
            transition: color 0.2s;
        }

        .profile-menu a:hover {
            color: #ffdd57;
        }

        .search-container {
            display: flex;
            justify-content: center;
            margin: 2rem 0;
        }

        .search-container input {
            border: 1px solid #ccc;
            padding: 0.5rem;
            border-radius: 5px;
            width: 300px;
        }

        .search-container button {
            margin-left: 0.5rem;
            padding: 0.5rem 1rem;
            border: none;
            background: #0077b6;
            color: #ffffff;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-container button:hover {
            background: #005f73;
        }

        .category-dropdown {
            margin: 1rem 0;
        }

        .category-dropdown select {
            border: 1px solid #ccc;
            padding: 0.5rem;
            border-radius: 5px;
            width: 100%;
        }

        .banner {
            display: flex;
            justify-content: center;
            align-items: center;
            background: #ffdd57;
            padding: 2rem;
            color: #0077b6;
            text-align: center;
            margin: 2rem 0;
        }

        .banner a {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: #0077b6;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 1rem;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
        }

        .product-card {
            background: #ffffff;
            padding: 1rem;
            border: 1px solid #ccc;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-card img {
            max-width: 100%;
            height: auto;
            margin-bottom: 1rem;
            border-radius: 10px;
        }

        .product-card h2 {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        .product-card p {
            color: #777;
            margin-bottom: 1rem;
        }

        .product-price {
            font-size: 1.25rem;
            color: #0077b6;
            margin-bottom: 0.5rem;
        }

        .product-card button {
            padding: 0.5rem 1rem;
            border: none;
            background: #0077b6;
            color: #ffffff;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .product-card .img-container {
    width: 100%;
    height: 200px; /* Set a fixed height for all image containers */
    display: flex;
    justify-content: center; /* Center the image horizontally */
    align-items: center; /* Center the image vertically */
    margin-bottom: 1rem; /* Add some space below the image */
}

.product-card img {
    max-width: 100%; /* Make sure the image does not overflow */
    max-height: 100%; /* Ensure the image fits within the container */
    height: auto; /* Maintain aspect ratio */
    border-radius: 10px; /* Add border radius if needed */
}


    </style>
</head>

<body>

    <header>
        <nav>
            <div class="logo">MEDICAL STORE</div>
            <div class="nav-links">
                <a href="homenew.php">Home</a>
                <a href="category.php">Category</a>
                <a href="cart.php">Cart</a>
                <a href="#">Contact Us</a>
                <a href="feedback.php">Feedback</a>
                <span class="profile-icon" onclick="toggleProfileMenu()">👤</span>
            </div>
        </nav>
        <div class="profile-menu" id="profile-menu">
            <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
            <a href="update_profile.html">Update Profile</a>
            <a href="logout.php">Logout</a>
        </div>
    </header>

    <main>
        <div class="search-container">
            <form method="GET" action="">
                <input type="text" id="search" name="search" placeholder="Search for medicines..."
                    value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <div class="product-grid">
    <?php foreach ($medicines as $medicine): ?>
        <div class="product-card">
            <div class="img-container">
                <?php if (!empty($medicine['image_path'])): ?>
                    <img src="<?php echo htmlspecialchars($medicine['image_path']); ?>"
                         alt="<?php echo htmlspecialchars($medicine['name']); ?>">
                <?php endif; ?>
            </div>
            <h2><?php echo htmlspecialchars($medicine['name']); ?></h2>
            <p><?php echo htmlspecialchars($medicine['description']); ?></p>
            <p class="product-price">₹ <?php echo htmlspecialchars($medicine['price']); ?></p>
            <button
                onclick="addToCart('<?php echo htmlspecialchars($medicine['name']); ?>', '<?php echo htmlspecialchars($medicine['price']); ?>')">Add
                to Cart</button>
        </div>
    <?php endforeach; ?>
</div>

 

     
    </main>

    <script>
        function toggleProfileMenu() {
            const profileMenu = document.getElementById('profile-menu');
            profileMenu.style.display = profileMenu.style.display === 'block' ? 'none' : 'block';
        }

        function addToCart(name, price) {
            console.log(`Added to cart: ${name}, Price: ₹${price}`);
            alert(`${name} has been added to your cart!`);

            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ name: name, price: price })
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Success:', data);
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }
    </script>
</body>

</html