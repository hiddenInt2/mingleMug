<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current Orders</title>
</head>
<Style>
    body{
        background-image: url('../Main-pictures/Background2.png');
        background-repeat: no-repeat;
        background-size: cover; 
        background-position: center; 
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        margin: 0;
        padding: 0;
        height: 100vh;
        display: grid;
        grid-template-rows:1fr auto;

    }
   
    .orders{
        border-collapse: collapse;
        width: 80%;
        text-align: center;
        
    }
    th,td{
        border: 1px solid black;
        padding: 10px;
        font-size: 18px;
        background-color: lightskyblue;
    }
    td:hover{
        background-color:cornflowerblue;
    }
    th:hover{
        background-color:cornflowerblue;
    }
    .back{
        width: 180px;
        height: 60px;
        color: black;
        background-color: burlywood;
        font-weight: bold;
        border-radius: 5px;
        border: 1px solid black;
        margin: 20px;
        display: block;
        text-align: center;
        
    }
    .back:hover{
        background-color:aliceblue;
        color:black;
    }
    .footer{
        display:flex;
        justify-content:flex-start;
        padding:10px;
    }
    .container {
            display: flex;
            justify-content: center; 
            align-items: center; 
    }
    .complete{
        background-color:burlywood;
        text-align:center;
        font-weight:bold;
        border-radius:2px;

    }
    .complete:hover{
        background-color:aliceblue;
    }
</Style>
<body>
    
    <div class="container"> 
    <!--Connect to a database to show the latest orders-->
        <table border="1" id="orders">
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Order Details</th>
                <th>Total Price</th>
                <th>Time of Order</th>
                <th>Estimated Time</th>
                <th>Order Number</th>
                <th>Fulfill</th>
            </tr>
            <?php
                // Database connection
                $servername = "mysql.minglemug.knechtkode.com";
                $username = "minglemug";
                $password = "minglemug1204";
                $dbname = "productsInfo";

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT first_name, last_name, order_details, total_price, time_of_order, estimated_time, order_number FROM currentorders";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data for each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['order_details']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['total_price']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['time_of_order']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['estimated_time']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['order_number']) . "</td>";
                        echo "<td><button class='complete' onclick='fulfillOrder(" . $row['order_number'] . ")'>Complete</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No orders found</td></tr>";
                }

                $conn->close();
            ?>
        </table>
    </div>

    <div class="footer">
        <a href="adminhome.html">
            <button class="back" type="button">Back to Admin Home</button>
        </a>
    </div>
    <script>
        function fulfillOrder(orderNumber) {
            alert('Order ' + orderNumber + ' Fulfilled');
            
        }
    </script>
</body>

</html>
