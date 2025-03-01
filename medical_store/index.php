<?php
// Include connection file
include 'connection.php';

// Start session
session_start();

// Check if user is logged in
$isLoggedIn = isset($_SESSION['usrname']);
$usrname = $isLoggedIn ? $_SESSION['usrname'] : null;

// Fetch user profile information if logged in
if ($isLoggedIn) {
    $sql_user = "SELECT email, username FROM credential WHERE username='$usrname'";
    $result_user = $conn->query($sql_user);
    $user = $result_user->fetch_assoc();
}

// Fetch medicines from database
$search_query = isset($_GET['search']) ? $_GET['search'] : '';
$sql_medicines = $search_query ?
    "SELECT name, description, image_path, price FROM medicines WHERE name LIKE '%$search_query%'" :
    "SELECT name, description, image_path, price FROM medicines";
$result_medicines = $conn->query($sql_medicines);
$medicines = $result_medicines->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Store</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body { font-family: 'Poppins', sans-serif; background: #f3f4f6; color: #333; }
        header { background: linear-gradient(to right, #1E3A8A, #2563EB); padding: 1rem; color: white; }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-weight: 500;
            transition: color 0.3s;
        }
        .nav-links a:hover { color: #FACC15; }
        
        .search-container {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        .search-container input {
            border: 2px solid #1E3A8A;
            padding: 10px;
            border-radius: 8px;
            width: 300px;
        }
        .search-container button {
            margin-left: 10px;
            padding: 10px 20px;
            border: none;
            background: #FFD700;
            color: black;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .search-container button:hover { background: #FFA500; }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
            padding: 1rem;
        }

        .product-card {
            background: white;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: black;
            transition: transform 0.2s;
        }
        .product-card:hover { transform: scale(1.03); }

        .product-card img {
            max-width: 100%;
            height: 180px;
            border-radius: 8px;
        }

        .product-price { font-size: 1.2rem; color: #2563EB; font-weight: bold; }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background: linear-gradient(to right, #2563EB, #1E3A8A);
            color: white;
            border-radius: 8px;
            font-weight: bold;
            transition: background 0.3s;
        }
        .btn:hover { background: #1E3A8A; }

        footer {
            background: #1E3A8A;
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 18px;
            margin-top: 20px;
        }
        .footer-links a {
            color: #FFD700;
            text-decoration: none;
            font-weight: bold;
            margin: 0 10px;
        }
        .footer-links a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<header>
    <nav class="flex justify-between items-center px-6 py-3 text-white">
        <div class="text-2xl font-bold">
            <i class="fa-solid fa-prescription-bottle-medical"></i> MEDICAL STORE
        </div>

        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="category.php">Category</a>
            <a href="cart.php">Cart</a>
            <a href="contact_us.php">Contact Us</a>
            <a href="feedback.php">Feedback</a>
            <?php if ($isLoggedIn): ?>
                <a href="logout.php" style="color: #FFD700;">Logout</a>
            <?php else: ?>
                <a href="login.php" style="color: #FFD700;">Login</a>
            <?php endif; ?>
        </div>
    </nav>
</header>

<div class="container">
    <div class="search-container">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search for medicines..." value="<?php echo htmlspecialchars($search_query); ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="product-grid">
        <?php foreach ($medicines as $medicine): ?>
            <div class="product-card">
                <img src="<?php echo htmlspecialchars($medicine['image_path']); ?>" alt="<?php echo htmlspecialchars($medicine['name']); ?>">
                <h2 class="font-bold text-lg"><?php echo htmlspecialchars($medicine['name']); ?></h2>
                <p class="text-sm text-gray-600"><?php echo htmlspecialchars($medicine['description']); ?></p>
                <p class="product-price">₹ <?php echo htmlspecialchars($medicine['price']); ?></p>
                <button class="btn"
                        onclick="<?php echo $isLoggedIn ? "addToCart('" . htmlspecialchars($medicine['name']) . "', '" . htmlspecialchars($medicine['price']) . "')" : "redirectToLogin()"; ?>">
                    Add to Cart
                </button>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<footer>
    <p>&copy; <?php echo date("Y"); ?> Medical Store. All rights reserved.</p>
    <p>Contact us at <a href="mailto:support@medicalstore.com">support@medicalstore.com</a></p>
    <div class="footer-links">
        <a href="about.php">About</a>
        <a href="contact_us.php">Contact Us</a>
    </div>
</footer>

<script>
    function redirectToLogin() {
        alert("You need to log in first!");
        window.location.href = "login.php";
    }

    function addToCart(name, price) {
        alert(name + " has been added to your cart!");
    }
</script>

</body>
</html>
