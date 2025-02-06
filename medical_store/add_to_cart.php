<?php
// Include database connection file
include 'connection.php';

// Start session
session_start();

// Retrieve item data from POST request
$data = json_decode(file_get_contents('php://input'), true);

// Debugging: Check the received data
if (is_null($data)) {
    echo json_encode(['success' => false, 'message' => 'No data received']);
    exit();
}

$name = $data['name'] ?? null;
$price = $data['price'] ?? null;

// Debugging: Check if name and price are set
if (is_null($name) || is_null($price)) {
    echo json_encode(['success' => false, 'message' => 'Invalid data received']);
    exit();
}

// Add item to session cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
$_SESSION['cart'][] = ['name' => $name, 'price' => $price];

// Obtain med_id corresponding to the medicine name from your database
$sql_med = "SELECT med_id FROM medicines WHERE name = ?";
$stmt_med = $conn->prepare($sql_med);
$stmt_med->bind_param('s', $name);
$stmt_med->execute();
$result_med = $stmt_med->get_result();

if ($result_med->num_rows > 0) {
    $row_med = $result_med->fetch_assoc();
    $med_id = $row_med['med_id'];
    $no_of_items = 1; // Set the number of items, you can adjust this as needed
    $date_time = date('Y-m-d H:i:s');

    // Insert item into orders table
    $sql = "INSERT INTO orders (med_id, no_of_items, date_time) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sis', $med_id, $no_of_items, $date_time);

    // Debugging statement
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Insert failed: ' . $stmt->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Medicine not found']);
}
?>
