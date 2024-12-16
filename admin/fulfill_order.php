<?php
header('Content-Type: application/json');

$servername = "mysql.minglemug.knechtkode.com";
$username = "minglemug";
$password = "minglemug1204";
$dbname = "productsInfo";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

// Get the JSON input
$data = json_decode(file_get_contents('php://input'), true);
$orderNumber = $data['orderNumber'] ?? null;

if (!$orderNumber) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input: Order number is required."]);
    exit();
}

// Start transaction
$conn->begin_transaction();

try {
    // Fetch the order details from the current orders table
    $sqlFetch = "SELECT * FROM currentorders WHERE order_number = ?";
    $stmtFetch = $conn->prepare($sqlFetch);
    $stmtFetch->bind_param("s", $orderNumber);
    $stmtFetch->execute();
    $result = $stmtFetch->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("Order not found.");
    }

    $order = $result->fetch_assoc();

    // Insert the order into the completed orders table
    $sqlInsert = "INSERT INTO completedorders (first_name, last_name, order_details, total_price, time_of_order, order_number)
                  VALUES (?, ?, ?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param(
        "ssssss",
        $order['first_name'],
        $order['last_name'],
        $order['order_details'],
        $order['total_price'],
        $order['time_of_order'],
        $order['order_number']
    );

    if (!$stmtInsert->execute()) {
        throw new Exception("Failed to insert order into completed orders: " . $stmtInsert->error);
    }

    // Remove the order from the current orders table
    $sqlDelete = "DELETE FROM currentorders WHERE order_number = ?";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bind_param("s", $orderNumber);

    if (!$stmtDelete->execute()) {
        throw new Exception("Failed to remove order from current orders: " . $stmtDelete->error);
    }

    // Commit transaction
    $conn->commit();

    echo json_encode(["success" => "Order fulfilled successfully."]);

} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}

// Close the connection
$conn->close();
?>