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

// Fetch products from the database time type
$sql = "SELECT name, type, price, quantity, time_of_day FROM products";
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
                        echo '<button class="product" onclick="showProductDetails(' . $row['name'] . ')">' . htmlspecialchars($row['name']) . '</button>';
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
        <footer class="productbuttons">
            <a href="adminhome.html">
                <button id="backbutton" class="back" type="button">Back to Admin Home</button>
            </a>
            <button id="editButton" class="edit" type="button">Edit Product</button>
            <button id="addButton" class="add" type="button">Add Product</button>
            <button  id="deleteButton" class="delete" type="button">Delete Product</button>
        </footer>

    <script>
        
        function showProductDetails(productId) {
            
            alert("Product ID: " + productId); 
        }
        document.addEventListener("DOMContentLoaded", () => {
                const addButton = document.querySelector(".add");
                const deleteButton = document.querySelector(".delete");
                const editButton = document.querySelector(".edit");
        
                addButton.addEventListener("click", () => {
                    // Check if the form already exists
                    if (document.querySelector(".edit-product-form")) {
                        alert("Edit Product form is already open.");
                        return;
                    }
                    if(document.querySelector(".delete-product-form")){
                        alert('Delete Product form is already open.');
                        return;
                    }
                    if(document.querySelector(".add-product-form")){
                        alert('Add Product form is already open.');
                        return;
                    }
                    // Create a form dynamically
                    const formContainer = document.createElement("div");
                    formContainer.classList.add("add-product-form");
        
                    formContainer.innerHTML = `
                       
                        <form id="addProductForm" class="addProductForm" method="POST" action="addProduct.php">
                             <h3>Add New Product</h3>
                            <label for="productName">Product Name:</label>
                            <input type="text" id="productName" name="productName" required><br><br>
        
                            <label for="productPrice">Price:</label>
                            <input type="number" id="productPrice" name="productPrice" step="0.01" required><br><br>
        
                            <label for="productQuantity">Quantity:</label>
                            <input type="number" id="productQuantity" name="productQuantity" required><br><br>
        
        
                            <label for="productCategory">Category:</label>
                            <select id="productCategory" name="productCategory" required>
                                <option value="drink">Drink</option>
                                <option value="food">Food</option>
                                <option value="dessert">Dessert</option>
                            </select><br><br>
        
                            <label for="timeOfDay">Time of Day:</label>
                            <select id="timeOfDay" name="timeOfDay" required>
                                <option value="morning">Morning</option>
                                <option value="afternoon">Afternoon</option>
                                <option value="evening">Evening</option>
                            </select><br><br>

                            <label for="productImage">Upload Product Image:</label>
                            <input type="file" id="productImage" name="productImage" accept="image/*" required><br><br>
        
                            <button type="submit">Add Product</button>
                            <button type="button" id="cancelAddProduct">Cancel</button>
                        </form>
                    `;
        
                    // Append form to the right panel
                    const rightPanel = document.querySelector(".rightpanel");
                    rightPanel.appendChild(formContainer);
        
                    // Cancel button functionality
                    const cancelButton = document.getElementById("cancelAddProduct");
                    cancelButton.addEventListener("click", () => {
                        formContainer.remove(); // Remove the form
                    });
                });
                
                deleteButton.addEventListener("click", () => {
                    // Check if the form already exists
                    if (document.querySelector(".edit-product-form")) {
                        alert("Edit Product form is already open.");
                        return;
                    }
                    if(document.querySelector(".delete-product-form")){
                        alert('Delete Product form is already open.');
                        return;
                    }
                    if(document.querySelector(".add-product-form")){
                        alert('Add Product form is already open.');
                        return;
                    }

                    // Create a form dynamically
                    const deleteFormContainer = document.createElement("div");
                    deleteFormContainer.classList.add("delete-product-form");

                    deleteFormContainer.innerHTML = `
                        
                        <form id="deleteProductForm" class="deleteProductForm" method="POST" action="deleteProduct.php">
                            <h3>Delete Product</h3>
                            <h4>Type the Name of the Product you wish to delete</h4>
                            <label for="productName">Product Name:</label>
                            <input type="text" id="productName" name="productName" required><br><br>

                            <button type="submit">Delete Product</button>
                            <button type="button" id="cancelDeleteProduct">Don't Delete</button>
                        </form>
                    `;

                    // Add the form to the right panel
                    const rightPanel = document.querySelector(".rightpanel");
                    rightPanel.appendChild(deleteFormContainer);

                    // Add cancel button functionality after the form is added to the DOM
                    const cancelButton = deleteFormContainer.querySelector("#cancelDeleteProduct");
                    cancelButton.addEventListener("click", () => {
                        deleteFormContainer.remove(); // Remove the form
                    });
                });

              
                editButton.addEventListener("click", () => {
                    // Check if the form already exists
                    if (document.querySelector(".edit-product-form")) {
                        alert("Edit Product form is already open.");
                        return;
                    }
                    if(document.querySelector(".delete-product-form")){
                        alert('Delete Product form is already open.');
                        return;
                    }
                    if(document.querySelector(".add-product-form")){
                        alert('Add Product form is already open.');
                        return;
                    }

                    // Create a form dynamically
                    const editFormContainer = document.createElement("div");
                    editFormContainer.classList.add("edit-product-form");

                    editFormContainer.innerHTML = `
                        
                        <form id="editProductForm" class="editProductForm" method="POST" action="editProduct.php">
                            <h3>Edit Product</h3>
                            <h4>Choose a Product you would like to Edit</h4>

                            <label for="productdropdown">Select the Product that you want to Edit:</label>
                            <select id="productDropdown" name="product" required>
                                
                            </select><br><br>

                            <label for="productPrice">Update Price:</label>
                            <input type="number" id="productPrice" name="productPrice" step="0.01" required><br><br>
        
                            <label for="productQuantity">Update Quantity:</label>
                            <input type="number" id="productQuantity" name="productQuantity" required><br><br>

                            <button type="submit">Save Changes</button>
                            <button type="button" id="cancelEditProduct">Cancel</button>
                        </form>
                    `;

                    // Add the form to the right panel
                    const rightPanel = document.querySelector(".rightpanel");
                    rightPanel.appendChild(editFormContainer);

                    // Add cancel button functionality after the form is added to the DOM
                    const canceleditButton = editFormContainer.querySelector("#cancelEditProduct");
                    canceleditButton.addEventListener("click", () => {
                        editFormContainer.remove(); // Remove the form
                    });
                    function populateDropdown(){
                        const dropdown = getElementById('productdropdown')
                        const items = document.quarySelectorAll('.productlist');
                        items.forEach(items => {
                            const option = document.createElement('option');
                            option.text.value = item.textContent;
                            dropdown.appendChild(option); 
                        });
                    };
                    window.onload = populateDropdown;
                });


                

            });
    </script>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
