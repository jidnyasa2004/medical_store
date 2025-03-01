<?php
session_start(); // ✅ Place this at the very top

// Check if the session cart exists, if not, initialize it
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0F2027, #203A43, #2C5364);
            font-family: 'Poppins', sans-serif;
            color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        header {
            width: 100%;
            background: rgba(0, 119, 182, 0.8);
            backdrop-filter: blur(10px);
            padding: 1rem;
        }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: auto;
        }
        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: white;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            margin: 0 1rem;
            font-weight: 500;
            transition: 0.3s ease;
        }
        .nav-links a:hover {
            color: #FFD700;
        }
        .container {
            max-width: 700px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            margin-bottom: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .cart-item h2 {
            font-size: 1.2rem;
            color: #FFD700;
        }
        .cart-item p {
            color: #D1D5DB;
        }
        .cart-item .price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #4ADE80;
        }
        .delete-btn {
            background: #DC2626;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s ease;
        }
        .delete-btn:hover {
            background: #B91C1C;
        }
        .total {
            font-size: 1.4rem;
            font-weight: bold;
            text-align: right;
            color: #FFD700;
            margin-top: 20px;
        }
        .align-right {
            text-align: right;
        }
        .checkout-btn {
            display: block;
            width: 100%;
            text-align: center;
            background: #16A34A;
            color: white;
            padding: 10px;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 5px;
            margin-top: 20px;
            transition: 0.3s ease;
        }
        .checkout-btn:hover {
            background: #15803D;
        }
        .empty-cart {
            text-align: center;
            font-size: 1.2rem;
            color: #F3F4F6;
            padding: 20px;
        }
        .header {
    position: fixed;
    top: 0;
    width: 100%;
    background: rgba(0, 119, 182, 0.9);
    backdrop-filter: blur(10px);
    z-index: 100;
}

    </style>
</head>

<body>




<main>
    <div class="container">
        <h1 class="text-3xl font-bold mb-5 text-center text-yellow-400">Your Cart</h1>

        <?php
 
        $totalAmount = 0;
        $totalItems = 0;

        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            foreach ($_SESSION['cart'] as $index => $item) {
                $totalAmount += $item['price'];
                $totalItems++;
                echo '<div class="cart-item">';
                echo '<div>';
                echo '<h2>' . htmlspecialchars($item['name']) . '</h2>';
                echo '<p class="price">₹' . htmlspecialchars($item['price']) . '</p>';
                echo '</div>';
                echo '<button class="delete-btn" onclick="removeFromCart(' . $index . ')"> Remove</button>';
                echo '</div>';
            }
            echo '<div class="total align-right">';
            echo '<p><strong>Total Items:</strong> ' . $totalItems . '</p>';
            echo '<p><strong>Total Amount:</strong> ₹' . $totalAmount . '</p>';
            echo '</div>';
            echo '<a href="order_summary.php" class="checkout-btn">Proceed to Order</a>';
        } else {
            echo '<p class="empty-cart">Your cart is empty. Start adding products! 🛍️</p>';
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
                location.reload(); // Refresh page to update cart
            } else {
                alert('Failed to remove item from cart');
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>

</body>

</html>
