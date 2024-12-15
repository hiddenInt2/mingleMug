<?php
// Database connection
$servername = "mysql.minglemug.knechtkode.com";
$username = "minglemug"; 
$password = "minglemug1204"; 
$dbname = "productsInfo"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productName'])) {
    $productName = $_POST['productName'];

    // Prepare the SQL query to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM products WHERE name = ?");
    $stmt->bind_param("s", $productName);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "Product deleted successfully.";
        } else {
            echo "No product found with the given name.";
        }
    } else {
        echo "Error deleting product: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request or missing product name.";
}

$conn->close();

?>