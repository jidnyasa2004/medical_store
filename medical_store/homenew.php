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
    $sql_medicines = "SELECT name, description, image_path, price FROM medicines";
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
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

        .product-card {
            background: #ffffff;
            padding: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
        }

        .product-card img {
            max-width: 100%;
            height: auto;
            margin-bottom: 1rem;
        }

        .product-card h2 {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        .product-card p {
            color: #777;
        }

        .product-price {
            font-size: 1.25rem;
            color: #0077b6;
        }

        .product-card button {
            margin-top: 0.5rem;
            padding: 0.5rem 1rem;
            border: none;
            background: #0077b6;
            color: #ffffff;
            border-radius: 5px;
            cursor: pointer;
        }

        .product-card button:hover {
            background: #005f73;
        }
    </style>
</head>

<body>

<header>
    <nav>
        <div class="logo">MEDICAL STORE</div>
        <div class="nav-links">
            <a href="#">Home</a>
            <a href="cart.php">Cart</a>
            <a href="#">Contact Us</a>
            <span class="profile-icon" onclick="toggleProfileMenu()">👤</span>
        </div>
    </nav>
    <div class="profile-menu" id="profile-menu">
        <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        <a href="update_profile.php">Update Profile</a>
        <a href="logout.php">Logout</a>
    </div>
</header>

<main>
    <div class="search-container">
        <input type="text" id="search" name="search" placeholder="Search for medicines...">
        <button onclick="searchMedicines()">Search</button>
    </div>

    <div class="category-dropdown">
        <select>
            <option value="aids-care">Aids & Care</option>
            <option value="for-adults">For Adults</option>
            <option value="for-children">For Children</option>
            <option value="personal-care-beauty">Personal Care & Beauty</option>
            <option value="health-products">Health Products</option>
            <option value="vitamins-supplements">Vitamins & Supplements</option>
        </select>
    </div>

    <div class="product-grid">
        <?php foreach ($medicines as $medicine): ?>
            <div class="product-card">
                <?php if (!empty($medicine['image_path'])): ?>
                    <img src="<?php echo htmlspecialchars($medicine['image_path']); ?>" alt="<?php echo htmlspecialchars($medicine['name']); ?>">
                <?php endif; ?>
                <h2><?php echo htmlspecialchars($medicine['name']); ?></h2>
                <p><?php echo htmlspecialchars($medicine['description']); ?></p>
                <p class="product-price">₹ <?php echo htmlspecialchars($medicine['price']); ?></p>
                <button onclick="addToCart('<?php echo htmlspecialchars($medicine['name']); ?>', '<?php echo htmlspecialchars($medicine['price']); ?>')">Add to Cart</button>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<script>
    function toggleProfileMenu() {
        const profileMenu = document.getElementById('profile-menu');
        profileMenu.style.display = profileMenu.style.display === 'block' ? 'none' : 'block';
    }

    function searchMedicines() {
        const searchInput = document.getElementById('search').value;
        console.log(`Searching for: ${searchInput}`);
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

</html>
