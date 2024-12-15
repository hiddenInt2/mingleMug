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

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $productName = $_POST['productDropdown'] ?? '';
    $productPrice = $_POST['productPrice'] ?? 0.0;
    $productQuantity = $_POST['productQuantity'] ?? 0;


    if (!empty($productName)) {
    
        $stmt = $conn->prepare("UPDATE products SET price = ?, quantity = ? WHERE name = ?");
        $stmt->bind_param("dis", $productPrice, $productQuantity, $productName);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "Product updated successfully.";
            }else {
                echo "No changes were made, or the product was not found.";
            }
        }else {
            echo "Error updating product: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Invalid product name. Please select a valid product.";
    }
}


$conn->close();
hearder("Location:productManagement.php");
?>

?>