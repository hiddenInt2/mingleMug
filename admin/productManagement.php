<?php
// Database connection
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "product_management"; 

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
        // JavaScript to load product details dynamically (Optional)
        function showProductDetails(productId) {
            // This function could make an AJAX request to fetch and display product details
            alert("Product ID: " + productId); // Replace with AJAX logic
        }
    </script>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
