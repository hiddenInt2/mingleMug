<?php
// Start the session
session_start();

// Set the Content-Type to JSON
header("Content-Type: application/json");

// Database credentials
$host = "mysql.minglemug.knechtkode.com";
$dbname = "productsInfo";
$username = "minglemug";
$password = "minglemug1204";

try {
    // Establish a database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => "Database connection failed."]);
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUsername = trim($_POST["username"]);
    $inputPassword = trim($_POST["password"]);

    // Query to find the user
    $query = "SELECT * FROM users WHERE user_name = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $inputUsername, PDO::PARAM_STR);
    $stmt->execute();

    // Check if the user exists
    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // Verify the password
        if (password_verify($inputPassword, $user["password"])) {
            // Password matches, log the user in
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $user["user_name"];
            echo json_encode(["success" => true]); // Login successful
        } else {
            // Invalid password
            echo json_encode(["success" => false, "error" => "Invalid password."]);
        }
    } else {
        // No account found
        echo json_encode(["success" => false, "error" => "No account found with that username."]);
    }
} else {
    // Invalid request method
    echo json_encode(["success" => false, "error" => "Invalid request method."]);
}

