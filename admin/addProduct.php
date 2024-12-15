<?php

// Database connection
$servername = "mysql.minglemug.knechtkode.com";
$username = "minglemug"; 
$password = "minglemug1204"; 
$dbname = "productsInfo"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $productName = $_POST['productName'] ?? '';
    $productPrice = $_POST['productPrice'] ?? 0.0;
    $productQuantity = $_POST['productQuantity'] ?? 0;
    $productType = $_POST['productCategory'] ?? '';
    $timeOfDay = $_POST['timeOfDay'] ?? '';

    if($productName && $productPrice && $productQuantity && $productType && $timeOFDay){

        $stmt = $conn->prepare("INSERT INTO products (name, type, time_of_day, price, quantity Values(?, ?,?,?,?");
        $STMT ->bind_param("sdisss",$productName,$productType,$timeOfDay,$productPrice,$productQuantity);

        if($stmt->excute()){
            echo"Product added successfully";
            header("Location:productManagement.php");
        }else{
            echo "Error: ". $stmt->error;
        }
        $stmt->close();
    }
    else{
        echo "Please fill in all fields";
    }


    }
$conn->close();
hearder("Location:productManagement.php");
?>