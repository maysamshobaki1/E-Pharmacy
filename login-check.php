<?php
session_start();

$dsn = "mysql:host=localhost;dbname=projectdb";
$username = "root";
$password = "";

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Failed to connect to the database: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $row = $stmt->fetch();

    if ($row && password_verify($password, $row['password'])) {
        $userId = $row["userId"];
        $name = $row["name"];
        $userType = $row["userType"];
        $imgName = $row["imgName"];
        $_SESSION["userId"] = $userId;
        $_SESSION["name"] = $name;
        $_SESSION["imgName"] = $imgName;

        if ($userType == 1) {
            header("Location: index.php");
            exit();
        } elseif ($userType == 2) {
            header("Location: admin/dashboard.php");
            exit();
        } elseif ($userType == 3) {
            header("Location: chat/chat.php");
            exit();
        
    } elseif ($userType == 4) {
        header("Location: driver.php");
        exit();
    }
    } else {
        $_SESSION['login_error']="Please Check Your Email and Password";
        header("Location: login.php");
        exit();
    }
} else {
    echo "Invalid login request!";
}

$conn = null;
?>
