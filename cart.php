<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2d8c8c, #73a1a1, #c3dfd9);
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
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        .cart-item h2 {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
            color: #2d8c8c;
        }
        .cart-item p {
            color: #555;
        }
        .cart-item .price {
            font-size: 1.25rem;
            color: #0077b6;
        }
        .cart-item .delete-btn {
            background: #e53e3e;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .cart-item .delete-btn:hover {
            background: #c53030;
        }
        .total {
            font-size: 1.5rem;
            margin-top: 20px;
            text-align: right;
            color: #2d8c8c;
        }
        .align-right {
            text-align: right;
        }
    </style>
</head>

<body>

<header>
    <nav>
        <div class="logo">MEDICAL STORE</div>
        <div class="nav-links">
        <a href="homenew.php">Home</a>
                <a href="#">Category</a>
                <a href="cart.php">Cart</a>
                <a href="#">Contact Us</a>
                <a href="#">Feedback</a>
              
        </div>
    </nav>
</header>

<main>
    <div class="container mx-auto mt-5">
        <h1 class="text-3xl font-bold mb-5 text-teal-700">Your Cart</h1>

        <?php
        session_start();
        $totalAmount = 0;
        $totalItems = 0;

        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            foreach ($_SESSION['cart'] as $index => $item) {
                $totalAmount += $item['price'];
                $totalItems++;
                echo '<div class="cart-item">';
                echo '<div>';
                echo '<h2 class="font-bold">' . htmlspecialchars($item['name']) . '</h2>';
                echo '<p class="price">Price: ₹' . htmlspecialchars($item['price']) . '</p>';
                echo '</div>';
                echo '<button class="delete-btn" onclick="removeFromCart(' . $index . ')">Delete</button>';
                echo '</div>';
            }
            echo '<div class="total align-right">';
            echo '<p><strong>Total Items:</strong> ' . $totalItems . '</p>';
            echo '<p><strong>Total Amount:</strong> ₹' . $totalAmount . '</p>';
            echo '</div>';
        } else {
            echo '<p>Your cart is empty.</p>';
        }
        ?>
    </div>
</main>

<script>
    function removeFromCart(index) {
        fetch('remove_from_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ index: index })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Refresh the page to show updated cart
            } else {
                alert('Failed to remove item from cart');
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>

</body>

</html>
