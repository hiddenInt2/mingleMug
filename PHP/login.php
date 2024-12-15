<?php
// Start the session
session_start();


// https://east1-phpmyadmin.dreamhost.com/signon.php?lang=en
$host = "mysql.minglemug.knechtkode.com"; // Database host
$dbname = "productsInfo"; // Database name
$username = "minglemug"; // Database username
$password = "minglemug1204"; // Database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
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
            $_SESSION["username"] = $user["username"];
            header("Location: adminhome.php"); // Redirect to admin dashboard
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No account found with that username.";
    }
}
?>