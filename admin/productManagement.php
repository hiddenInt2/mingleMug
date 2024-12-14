<?php
// Database connection
$servername = "mysql.minglemug.knechtkode.com";
$username = "minglemug"; 
$password = "minglemug1204"; 
$dbname = "productsInfo"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products from the database
$sql = "SELECT id, title, price, quantity, description, image, time_of_day, category FROM products";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="productManagement.css">
    <title>Admin Access: Product Management</title>
</head>
<body>
    <h1>Product <br> Management</h1>
    <hr>
    <h2>Product List</h2>
    <div class="container">
        <div class="leftpanel">
            <div class="productlist">
                <?php
                // Generate product buttons
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<button class="product" onclick="showProductDetails(' . $row['id'] . ')">' . htmlspecialchars($row['title']) . '</button>';
                    }
                } else {
                    echo "<p>No products available.</p>";
                }
                ?>
            </div>
        </div>
        <div class="rightpanel" id="productDetails">
            <!-- Product details will be dynamically updated via JavaScript or PHP -->
        </div>
    </div>

    <script>
        
        function showProductDetails(productId) {
            
            alert("Product ID: " + productId); 
        }
    </script>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
