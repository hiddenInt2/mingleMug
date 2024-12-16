<?php
session_start();
header("Content-Type: application/json");

// Database credentials
$host = "mysql.minglemug.knechtkode.com";
$dbname = "productsInfo";
$username = "minglemug";
$password = "minglemug1204";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => "database"]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inputUsername = htmlspecialchars(trim($_POST["username"] ?? ""));
    $inputPassword = trim($_POST["password"] ?? "");

    if (empty($inputUsername) || empty($inputPassword)) {
        echo json_encode(["success" => false, "error" => "empty"]);
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_name = :username");
    $stmt->bindParam(":username", $inputUsername, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() === 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($inputPassword, $user["password"])) {
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $user["user_name"];
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => "password"]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "username"]);
    }
} else {
    echo json_encode(["success" => false, "error" => "invalid"]);
}
?>
